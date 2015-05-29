<?php

namespace FrameworkTest\Services;

use PHPUnit_Framework_TestCase;

class ConfigurationServiceTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function testGetService() {
        $serviceManager = \Bootstrap::getServiceManager();
        $configuration = $serviceManager->get('Configuration');
        $this->assertInstanceOf('\Framework\Services\ConfigurationServiceInterface', $configuration);
        $configuration->setConfig(array('test' => 'test'));
        $config = $configuration->getConfig();
        $this->assertArrayHasKey('test', $config);
    }

}
