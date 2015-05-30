<?php

namespace ApplicationTest\MVC\Controller;

use FrameworkTest\Helpers\AbstractHttpTestCase;

class PeopleControllerTest extends AbstractHttpTestCase {

    protected function getAppConfig() {
        return require __DIR__ . '/../../../../application/MVC/config.php';
    }

    public function setUp() {
        parent::setUp();
    }

    public function testGet() {
        //$controller = new \Application\Controller\PeopleController($this->getMock('\Application\Services\PersonService'));
        //$this->assertInternalType('array', $controller->get(1));
    }

    public function testRunApplication() {
        $this->dispatch('/people/12');
        $this->assertResponseStatusCode(200);
        $this->assertJson($this->getResponse()->getContent());
    }

}
