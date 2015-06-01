<?php

return array(
    'repositories' => array('person' => array(
            'class' => '\Backend\Infrastructure\Persistence\Repository\PersonRepository',
            'file' => __DIR__ . '/../../data/example.csv',
            'hydrate_to_object' => '\Backend\Model\Person',
            'fields' => array(
                'name',
                'phone',
                'address'
            )
        )
    )
);
