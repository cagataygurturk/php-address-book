<?php

namespace ApplicationTest\Model;

use PHPUnit_Framework_TestCase;
use Application\Model\Person;

class PersonTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        parent::setUp();
    }

    /**
     * @group lists
     * Tests the api edit form
     */
    public function testPersonCreateTest() {

        $person = new Person();
        $this->assertInstanceOf('\Application\Model\Person', $person);

        /* Test data */
        $name = 'Cagatay Gurturk';
        $phone = '34603547254';
        $address = 'Comte Borrell, 151, 1-1';

        $person->setName($name);
        $person->setPhone($phone);
        $person->setAddress($address);
        $this->assertEquals($name, $person->getName());
        $this->assertEquals($phone, $person->getPhone());
        $this->assertEquals($address, $person->getAddress());
    }

}
