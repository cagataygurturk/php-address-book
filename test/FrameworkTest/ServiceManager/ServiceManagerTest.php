<?php

namespace FrameworkTest\ServiceManager;

use PHPUnit_Framework_TestCase;

class PersonTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function testGetService() {
        $serviceManager = \Bootstrap::getServiceManager();
        $this->assertInstanceOf('Framework\ServiceManager\ServiceManagerInterface', $serviceManager);

        $mockServiceClass = 'FrameworkTest\Helpers\MockService';


        $mockService = $serviceManager->get('MockService');
        $this->assertInstanceOf($mockServiceClass, $mockService);

        $mockServiceByFactory = $serviceManager->get('MockService');
        $this->assertInstanceOf($mockServiceClass, $mockServiceByFactory);

        //test if only one instance is created per name

        $testVariable = 'test';
        $mockService->testVariable = $testVariable;
        $newMockService = $serviceManager->get('MockService');
        $this->assertEquals($testVariable, $newMockService->testVariable);
    }

}
