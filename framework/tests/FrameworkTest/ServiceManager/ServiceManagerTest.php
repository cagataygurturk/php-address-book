<?php

namespace FrameworkTest\ServiceManager;

use PHPUnit_Framework_TestCase;

class PersonTest extends \FrameworkTest\TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function testGetService() {
        $serviceManager = $this->getServiceManager();
        $this->assertInstanceOf('Framework\ServiceManager\ServiceManagerInterface', $serviceManager);

        $mockServiceClass = 'FrameworkTest\Helpers\MockService2';

        $mockService = $serviceManager->get('FrameworkTest\Helpers\MockService2');
        $this->assertInstanceOf($mockServiceClass, $mockService);

        $mockServiceByFactory = $serviceManager->get('FrameworkTest\Helpers\MockService2');
        $this->assertInstanceOf($mockServiceClass, $mockServiceByFactory);

        //test if only one instance is created per name

        $testVariable = 'test';
        $mockService->testVariable = $testVariable;
        $newMockService = $serviceManager->get('FrameworkTest\Helpers\MockService2');
        $this->assertEquals($testVariable, $newMockService->testVariable);
    }

}
