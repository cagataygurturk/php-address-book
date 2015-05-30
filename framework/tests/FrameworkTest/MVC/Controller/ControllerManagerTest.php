<?php

namespace FrameworkTest\MVC\Controller;

use PHPUnit_Framework_TestCase;

class ControllerManagerTest extends \FrameworkTest\TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function testGetController() {
        $serviceManager = $this->getServiceManager();
        $controllerManager = $serviceManager->get('ControllerManager');


        $mockController = $controllerManager->get('FrameworkTest\Helpers\MockController');
        $this->assertInstanceOf('\Framework\MVC\Controller\ControllerInterface', $mockController);
        $mockControllerByFactory = $controllerManager->get('MockControllerByFactory');
        $this->assertInstanceOf('\Framework\MVC\Controller\ControllerInterface', $mockControllerByFactory);
    }

}
