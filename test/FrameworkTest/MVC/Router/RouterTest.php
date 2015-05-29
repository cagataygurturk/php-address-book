<?php

namespace FrameworkTest\Services;

use PHPUnit_Framework_TestCase;

class RouterTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function testMatchRoute() {
        $serviceManager = \Bootstrap::getServiceManager();
        $router = $serviceManager->get('Router');
        $this->assertInstanceOf('\Framework\MVC\Router\RouterInterface', $router);

        $router->addRoutes(array(
            array('GET', '/people', 'people', 'getList'),
            array('GET', '/people/[i:id]', 'people', 'get'),
            array('DELETE', '/people/[i:id]', 'people', 'delete')
        ));


        $this->assertNotEquals(false, $router->match(\Framework\MVC\Request\Request::factory(array(
                            'uri' => '/people/12',
        ))));

        $this->assertFalse($router->match(\Framework\MVC\Request\Request::factory(array(
                            'uri' => '/people/12',
                            'method' => 'POST'
        ))));

        $this->assertFalse($router->match(\Framework\MVC\Request\Request::factory(array(
                            'uri' => '/people',
                            'method' => 'POST'
        ))));
    }

}
