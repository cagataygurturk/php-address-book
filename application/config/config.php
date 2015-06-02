<?php

return array(
    /* Service manager configuration */
    'service_manager' => array(
        'aliases' => array(),
        'factories' => array(
            'Application\Services\PersonService' => 'Application\Services\Factories\PersonServiceFactory'
        )
    ),
    'routes' => array(
        array('/people', 'Application\MVC\Controller\PeopleController', 'rest'),
        array('/people/[:id]', 'Application\MVC\Controller\PeopleController', 'rest'),
    ),
    'controllers' => array(
        'invokables' => array(
        ),
        'factories' => array(
            'Application\MVC\Controller\PeopleController' => 'Application\MVC\Factories\PeopleControllerFactory'
        )
    )
);
