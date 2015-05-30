<?php

namespace ApplicationTest\MVC\Factories;

use PHPUnit_Framework_TestCase;

class PersonServiceFactoryTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function testGetService() {
        $serviceManager = \Bootstrap::getServiceManager();
        $mockService = $serviceManager->get('Application\Services\PersonService');
        $this->assertInstanceOf('\Application\Services\PersonServiceInterface', $mockService);
    }

}
