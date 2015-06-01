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
        $this->assertGreaterThan(0, count($allpeople));
    }

    public function testFindOneRow() {
        $factory = new PersonServiceFactory();
        $service = $factory->createService();
        $searchResult = $service->getPersonById(1);

        $this->assertGreaterThan(0, count($searchResult));
        $this->assertEquals(1, $searchResult[0]->getId());
    }

    public function testInsertNewPersonAndDelete() {
        $factory = new PersonServiceFactory();
        $service = $factory->createService();

        $person = $service->insert('John Doe', '0000000000', 'New York');
        $this->assertInstanceOf('\Backend\Model\Person', $person);
        $search = $service->getPersonById($person->getId());
        $this->assertGreaterThan(0, count($search));
        $this->assertTrue($service->delete($person->getId()));
    }

}
