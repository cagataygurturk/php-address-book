<?php

namespace FrameworkTest\Services;

use PHPUnit_Framework_TestCase;

class ConfigurationServiceTest extends \FrameworkTest\TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function testGetService() {
        $configuration = new \Framework\Services\ConfigurationService();
        $this->assertInstanceOf('\Framework\Services\ConfigurationServiceInterface', $configuration);
        $configuration->setConfig(array('test' => 'test'));
        $config = $configuration->getConfig();
        $this->assertArrayHasKey('test', $config);
    }

}
