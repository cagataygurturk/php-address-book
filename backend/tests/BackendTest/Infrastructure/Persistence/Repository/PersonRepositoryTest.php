<?php

namespace BackendTest\Infrastructure\Persistence\Repository\EntityRepository;

use PHPUnit_Framework_TestCase;
use Backend\Infrastructure\Persistence\Repository\PersonRepository;

class PersonRepositoryTest extends PHPUnit_Framework_TestCase {

    protected $config;

    public function setUp() {
        parent::setUp();
        $this->config = array(
            'class' => '\Backend\Infrastructure\Persistence\Repository\PersonRepository',
            'file' => __DIR__ . '/../../../../data/example.csv',
            'hydrate_to_object' => '\Backend\Model\Person',
            'fields' => array(
                'id',
                'name',
                'phone',
                'address'
            )
        );
    }

    public function testGetAllRows() {
        $dataReader = new PersonRepository($this->config);
        $allrows = $dataReader->getAllRows();
        $firstObject = $allrows[0];
        $this->assertInstanceOf('\Backend\Model\Person', $firstObject);
        $this->assertNotNull($firstObject->getName());
        $this->assertNotNull($firstObject->getPhone());
        $this->assertNotNull($firstObject->getAddress());
    }

    public function testGetFindRowAll() {
        $nameToSearch = 'Marcin';
        $dataReader = new PersonRepository($this->config);
        $allrows = $dataReader->findByCriteria(array('name' => $nameToSearch), null);
        $this->assertEquals(1, count($allrows));
        $firstObject = $allrows[0];
        $this->assertInstanceOf('\Backend\Model\Person', $firstObject);
        $this->assertEquals($nameToSearch, $firstObject->getName());
    }

    public function testGetFindRowOne() {
        $nameToSearch = 'Marcin';
        $database = new PersonRepository($this->config);
        $allrows = $database->findByCriteria(array('name' => $nameToSearch), 1);
        $this->assertEquals(1, count($allrows));
        $firstObject = $allrows[0];
        $this->assertInstanceOf('\Backend\Model\Person', $firstObject);
        $this->assertEquals($nameToSearch, $firstObject->getName());
    }

    public function testAddObject() {
        $database = new PersonRepository($this->config);

        $person = new \Backend\Model\Person();
        $name = 'Cagatay';
        $phone = '603547264';
        $address = 'Comte Borrell 151';
        $person->setName($name);
        $person->setPhone($phone);
        $person->setAddress($address);
        $database->insert($person);

        $allrows = $database->findByCriteria(array('name' => $name, 'phone' => $phone, 'address' => $address), 1);
        $inserted_object = $allrows[0];
        $this->assertInstanceOf('\Backend\Model\Person', $inserted_object);
        $this->assertEquals($name, $inserted_object->getName());
        $this->assertEquals($phone, $inserted_object->getPhone());
        $this->assertEquals($address, $inserted_object->getAddress());
    }

    public function testDeleteObject() {
        $database = new PersonRepository($this->config);

        $person = new \Backend\Model\Person();
        $name = 'Cagatay';
        $phone = '603547264';
        $address = 'Comte Borrell 151';
        $person->setName($name);
        $person->setPhone($phone);
        $person->setAddress($address);
        $database->insert($person);

        $this->assertTrue($database->delete(array('name' => $name)));

        $allrows = $database->findByCriteria(array('name' => $name, 'phone' => $phone, 'address' => $address), 1);
        $this->assertEquals(0, count($allrows));
    }

}
