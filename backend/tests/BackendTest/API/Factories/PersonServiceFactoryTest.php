<?php

namespace BackendTest\BackendTest\API\Factories;

use PHPUnit_Framework_TestCase;
use Backend\API\Factories\PersonServiceFactory;

class PersonServiceFactoryTest extends PHPUnit_Framework_TestCase {

    protected $config;

    public function setUp() {
        parent::setUp();
    }

    public function testCreateService() {
        $factory = new PersonServiceFactory();
        $service = $factory->createService();

        $this->assertInstanceOf('\Backend\API\PersonService\PersonService', $service);
    }


}
