<?php

return array(
    'repositories' => array(
        /*
         * Each section behaves like RDBMS tables. Each table, thus, should have its own .csv file
         * class indicates the Repository class for this table
         * hydrate_to_object indicates instances of which class will be created for each line in the .csv file
         * fields should include column names for comma-seperated values and they have to have their
         * getter and setters in hydrate_to_object class
         */
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
);
