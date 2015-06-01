<?php

namespace ApplicationTest\MVC\Controller;

class PeopleControllerTest extends \FrameworkTest\Helpers\AbstractHttpTestCase {

    protected function getAppConfig() {
        return require __DIR__ . '/../../../../config/config.php';
    }

    public function setUp() {
        parent::setUp();
    }

    public function testGet() {
        //$controller = new \Application\Controller\PeopleController($this->getMock('\Application\Services\PersonService'));
        //$this->assertInternalType('array', $controller->get(1));
    }

    public function testGetId() {
        $this->dispatch('/people/1');
        $this->assertResponseStatusCode(200);
        $this->assertJson($this->getResponse()->getContent());
        $response = json_decode($this->getResponse()->getContent(), true);
        $this->assertArrayHasKey('people', $response);
        $this->assertGreaterThan(0, count($response['people']));
    }

    public function testNotFound() {
        $this->dispatch('/people/12');
        $this->assertResponseStatusCode(404);
        $this->assertJson($this->getResponse()->getContent());
    }

    public function testGetAll() {
        $this->dispatch('/people');
        $this->assertResponseStatusCode(200);
        $this->assertJson($this->getResponse()->getContent());
        $response = json_decode($this->getResponse()->getContent(), true);
        $this->assertArrayHasKey('people', $response);
        $this->assertGreaterThan(1, count($response['people']));
    }

}
