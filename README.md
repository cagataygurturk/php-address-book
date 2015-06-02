[![Build Status](https://travis-ci.org/cagataygurturk/challenge.svg)](https://travis-ci.org/cagataygurturk/challenge)

People REST Service
=========

People Book is a small but overengineered PHP application that only aims to show how to implement a basic MVC framework with Routing, Service Locator and REST support and seperate business and data layers like DDD in PHP.

Installation
=========

The project does not use any external libraries except PHPUnit for unit testing but still it uses Composer's autoloading (following psr-4 standards). After cloning the repository, on the main working directory type:

    $ composer install

Then you can run tests typing

    $ phpunit

This runs unit tests together. Alternatively, you can run tests on 3 layers independently typing

    $ phpunit framework
    $ phpunit backend
    $ phpunit application

The tests in "application/tests" folder are mainly functional and integration tests. 

Usage
=========

All the application just runs on a single router script at application/public/index.php

To run the built-in PHP server just type

     php -S localhost:8000 application/public/index.php 
    
And navigate to http://localhost:8000 by your favourite web browser or a REST client like Postman. Supported endpoints are:

    /people [GET, POST]
    /people/[:id] [GET, DELETE]

Structure
=========

The project consists on 3 layers:

 - Framework: A basic MVC framework built from scratch.
 - Backend: The Business layer sits here.
 - Application: A MVC application built on the newly developed MVC framework and consumes Backend's API.

## Framework ##

The MVC framework is deeply inspired by ZF2. It needs three main configurations: router, controllers and service manager configuration. (see application/config/config.php)

### Service Manager ###

Service Manager implements Service Locator Pattern for injecting dependencies. Services are configured as follows:

    'service_manager' => array(
            'invokables' => array(),
            'factories' => array(
                'Application\Services\PersonService' => 'Application\Services\Factories\PersonServiceFactory'
            )
        )
        
Services can be created directly by "invokables" section if they do not need any dependency and can be created by calling the constructor. But many times it is not the case and upon creating a service we need to inject the needed dependencies. Therefore we can use Factory classes implementing **Framework\ServiceManager\FactoryInterface** interface.

The service locater only creates one instance of every service.

### Controller Manager ###

"controllers" section of config.php can include directly invokable controllers or controller factories. For our single controller (PeopleController) we created a factory because this controller needs a dependency (Application\Services\PersonService)

    'controllers' => array(
            'invokables' => array(
            ),
            'factories' => array(
                'Application\MVC\Controller\PeopleController' => 'Application\MVC\Factories\PeopleControllerFactory'
            )
        )
       
By this way, when the application invokes **Application\MVC\Controller\PeopleController** class, **ControllerManager** invokes the **Application\MVC\Factories\PeopleControllerFactory** class and creates the controller with its dependencies

Controllers should extend **Framework\MVC\Controller\Controller** abstract class. This abstract class provides some useful methods like **getRequest()**, **getResponse()**. By this method a controller method can access basic properties of the request and alter some properties of the Response object such as content or HTTP Status Code.

Controllers should return an object implementing **Framework\MVC\ViewModel\ViewModelInterface** object, an array or Response object.

When it returns **ViewModelInterface** render() method of the ViewModel is sent to users. When it returns an array, JSON or XML responses are returned in function of Accept-type header. If it returns Response, this object is returned to the client without modification.

### Router ###

Router config is configured as follows:

     'routes' => array(
            array('/people', 'Application\MVC\Controller\PeopleController', 'rest'),
            array('/people/[:id]', 'Application\MVC\Controller\PeopleController', 'rest'),
        ),

The first argument is the path, the second one is the controller name and the third one is action.

Normally when an action named "**test**" is defined in routing section, it must be implemented as "**public function testAction()**" in the controller, but **Application\MVC\Controller\PeopleController** extends **Framework\MVC\Controller\RESTfulController** which is a special controller variation for REST requests. RESTfulController has only one action **restAction** and according to the HTTP verb and the path, it detects which function to call. Thanks to **RESTfulController** REST endpoint controllers can be implemented without having to deal with HTTP verbs. Please see **Application\MVC\Controller\PeopleController** for implementation details.

Backend
=========
Backend is where sits all the business logic. Backend is implemented isolated, so it does not depend on any frameworks and can be reused independently. Backend includes a **Repository** layer that operates on **Backend\Model\Entity** objects and isolates all the data access methods. Currently it uses CSV data store. Before using the repository it should be configured as it is on backend/config/config.php

    'repositories' => array(
    'person' => array(
                'class' => '\Backend\Infrastructure\Persistence\Repository\PersonRepository',
                'file' => __DIR__ . '/../../data/example.csv',
                'hydrate_to_object' => '\Backend\Model\Person',
                'fields' => array(
                    'id',
                    'name',
                    'phone',
                    'address'
                )
            )
        )

This configuration section maps every line of the .csv file to an object. Each subsection (like 'person') of this configuration can be thought of like tables of RDBMS. Class name given in 'class' property should extend **Backend\Infrastructure\Persistence\Repository\EntityRepository**, the class given 'hydrate_to_object' should extend **Backend\Model\Entity** class. 'fields' section should include the properties of each line with the right order. Also the class to be hydrated should implement getter and setters with field names. (See **Backend\Model\Person** implementation.)

The Backend includes a service called **Backend\API\PersonService** that operates on objects and uses the repository to persist them. Due to our limited domain, this service does not include many business rules (actually any) but these can be implemented easily.

Highlights
=========

This application is designed to be looesly coupled. Almost all components are independents, their dependencies are defined by interfaces which makes eaiser testing and all the dependencies are injected on runtime.

The application layer communicates with backend only using PersonService and the backend does not depend on any other layers, it is configured explicitly.

Data Access Layer is very flexible. Implementing EntityRepositoryInterface, the data storage mechanism can be changed without any modification on upper layers.

HTTP application uses REST verbs and HTTP status codes for communicating with the client. For example, for a request that do not return any results, the client also gets 404 status code. For a deleted object it gives a 204 (No Content) status code. For better control on the status codes, the application uses exceptions. Every derived exception (like **Application\Exception\NotFoundException**) has a HTTP status code (default 500) in its \$code property. So, when an unhandles exception occurs for the MVC framework sends the \$code property of the thrown Exception. Actually it's very nice method to control HTTP status code that I love, also HHVM had a bug about this subject reported by me: https://github.com/facebook/hhvm/issues/4379 