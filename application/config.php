<?php

return array(
    /* Service manager configuration */
    'service_manager' => array(
        'aliases' => array(),
        'factories' => array(
            'PersonService' => 'Application\Factories\PersonServiceFactory'
        )
    ),
    'data_reader' => array(
        'adapter' => 'Application\DAL\CSVDataLayer',
        'adapter_config' => array(
            'file' => __DIR__ . '/../data/example.csv',
            'hydrate_to_object' => 'Application\Model\Person',
            'fields' => array(
                'name',
                'phone',
                'address'
            )
        )
    ),
    'routes' => array(
        array('GET', '/people', 'PeopleController', 'getList'),
        array('GET', '/people/[i:id]', 'PeopleController', 'get'),
        array('DELETE', '/people/[i:id]', 'PeopleController', 'delete')
    ),
    'controllers' => array(
        'aliases' => array(
        ),
        'factories' => array(
            'PeopleController' => 'Application\Factories\PeopleControllerFactory'
        )
    )
);
