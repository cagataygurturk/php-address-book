<?php

namespace ApplicationTest\MVC\Controller;

class PeopleControllerTest extends \FrameworkTest\Helpers\AbstractHttpTestCase {

    protected function getAppConfig() {
        return require __DIR__ . '/../../../../config/config.php';
    }

    public function setUp() {
        parent::setUp();
    }

    public function testNotFound() {
        $this->dispatch('/');
        $this->assertResponseStatusCode(404);
    }

    public function testGetId() {
        $this->dispatch('/people/1');
        $this->assertResponseStatusCode(200);
        $this->assertJson($this->getResponse()->getContent());
        $response = json_decode($this->getResponse()->getContent(), true);
        $this->assertGreaterThan(0, count($response));
    }

    public function testNotFoundResource() {
        $this->dispatch('/people/12');
        $this->assertResponseStatusCode(404);
        $this->assertJson($this->getResponse()->getContent());
    }

    public function testGetAll() {
        $this->dispatch('/people');
        $this->assertResponseStatusCode(200);
        $this->assertJson($this->getResponse()->getContent());
        $response = json_decode($this->getResponse()->getContent(), true);
        $this->assertGreaterThan(1, count($response));
    }

}
