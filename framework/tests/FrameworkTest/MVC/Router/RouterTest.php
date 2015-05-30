<?php

namespace FrameworkTest\MVC\Router;

use PHPUnit_Framework_TestCase;

class RouterTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function testMatchRoute() {
        $router = new \Framework\MVC\Router\Router();

        $router->addRoutes(array(
            array('/people', 'people', null),
            array('/people/[i:id]', 'people', null),
            array('/people/[i:id]', 'people', null)
        ));


        $this->assertNotEquals(false, $router->match(\Framework\MVC\Request\Request::factory(array(
                            'uri' => '/people/12',
        ))));

        $this->assertFalse($router->match(\Framework\MVC\Request\Request::factory(array(
                            'uri' => '/peoples/12',
                            'method' => 'POST'
        ))));

        $this->assertFalse($router->match(\Framework\MVC\Request\Request::factory(array(
                            'uri' => '/peoples',
                            'method' => 'POST'
        ))));
    }

}
