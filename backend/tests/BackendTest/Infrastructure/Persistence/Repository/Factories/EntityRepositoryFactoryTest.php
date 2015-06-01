<?php

namespace BackendTest\Infrastructure\Persistence\Repository\EntityRepository;

use PHPUnit_Framework_TestCase;
use Backend\Infrastructure\Persistence\Repository\Factories\EntityRepositoryFactory;

class EntityRepositoryFactoryTest extends PHPUnit_Framework_TestCase {

    protected $config;

    public function setUp() {
        parent::setUp();
    }

    /**
     * @expectedException     \Backend\Exception\ServiceException
     */
    public function testAttemptToCreateNotExistingRepository() {
        $factory = new EntityRepositoryFactory(array(
            'person' => array(
                'class' => '\Backend\Infrastructure\Persistence\Repository\PersonRepository',
                'file' => __DIR__ . '/../../../../../data/example.csv',
                'hydrate_to_object' => '\Backend\Model\Person',
                'fields' => array(
                    'name',
                    'phone',
                    'address'
                )
            )
        ));
        $factory->createRepository('person2');
    }

    /**
     * @expectedException     \Backend\Exception\ServiceException
     */
    public function testAttemptToCreateNotExistingClass() {
        $factory = new EntityRepositoryFactory(array('person' => array(
                'class' => '\Backend\Infrastructure\Persistence\Repository\PersonRepositories',
                'file' => __DIR__ . '/../../../../../data/example.csv',
                'hydrate_to_object' => '\Backend\Model\Person',
                'fields' => array(
                    'name',
                    'phone',
                    'address'
                )
        )));
        $factory->createRepository('person');
    }

    public function testCreateRepository() {
        $factory = new EntityRepositoryFactory(array(
            'person' => array(
                'class' => '\Backend\Infrastructure\Persistence\Repository\PersonRepository',
                'file' => __DIR__ . '/../../../../../data/example.csv',
                'hydrate_to_object' => '\Backend\Model\Person',
                'fields' => array(
                    'name',
                    'phone',
                    'address'
                )
            )
        ));
        $repository = $factory->createRepository('person');
        $this->assertInstanceOf('\Backend\Infrastructure\Persistence\Repository\PersonRepository', $repository);
    }

}
