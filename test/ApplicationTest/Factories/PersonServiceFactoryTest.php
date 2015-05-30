<?php

namespace ApplicationTest\Factories;

use PHPUnit_Framework_TestCase;

class PersonServiceFactoryTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function testGetService() {
        $serviceManager = \Bootstrap::getServiceManager();

        $mockService = $serviceManager->get('PersonService');
        $this->assertInstanceOf('\Application\Services\PersonServiceInterface', $mockService);
    }

}
