<?php

namespace FrameworkTest\MVC\Controller;

use PHPUnit_Framework_TestCase;

class ControllerManagerTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function testGetController() {
        $serviceManager = \Bootstrap::getServiceManager();
        $controllerManager = $serviceManager->get('ControllerManager');


        $mockController = $controllerManager->get('MockController');
        $this->assertInstanceOf('\Framework\MVC\Controller\ControllerInterface', $mockController);
        $mockControllerByFactory = $controllerManager->get('MockControllerByFactory');
        $this->assertInstanceOf('\Framework\MVC\Controller\ControllerInterface', $mockControllerByFactory);
    }

}
