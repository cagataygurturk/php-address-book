<?php

namespace BackendTest\API;

use PHPUnit_Framework_TestCase;
use Backend\API\Factories\PersonServiceFactory;

class PersonServiceTest extends PHPUnit_Framework_TestCase {

    protected $config;

    public function setUp() {
        parent::setUp();
    }

    public function testFindAllRows() {
        $factory = new PersonServiceFactory();
        $service = $factory->createService();
        $allpeople = $service->getAllPeople();
        $this->assertArrayHasKey('people', $allpeople);
        $this->assertGreaterThan(0, count($allpeople['people']));
    }

}
