<?php

return array(
    /* Service manager configuration */
    'service_manager' => array(
        'aliases' => array(),
        'factories' => array(
            'Application\Services\PersonService' => 'Application\MVC\Factories\PersonServiceFactory'
        )
    ),
    'data_reader' => array(
        'adapter' => 'Application\Repository\CSVDataLayer',
        'adapter_config' => array(
            'file' => __DIR__ . '/../../../data/example.csv',
            'hydrate_to_object' => 'Application\Model\Person',
            'fields' => array(
                'name',
                'phone',
                'address'
            )
        )
    ),
    'routes' => array(
        array('/people', 'Application\MVC\Controller\PeopleController', 'rest'),
        array('/people/[i:id]', 'Application\MVC\Controller\PeopleController', 'rest'),
    ),
    'controllers' => array(
        'invokables' => array(
        ),
        'factories' => array(
            'Application\MVC\Controller\PeopleController' => 'Application\MVC\Factories\PeopleControllerFactory'
        )
    )
);
