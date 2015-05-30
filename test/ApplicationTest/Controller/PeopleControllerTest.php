<?php

namespace ApplicationTest\Services;

use FrameworkTest\Helpers\AbstractHttpTestCase;

class PeopleControllerTest extends AbstractHttpTestCase {

    protected function getAppConfig() {
        return require __DIR__ . '/../../../application/config.php';
    }

    public function setUp() {
        parent::setUp();
    }

    public function testRunApplication() {
        $this->dispatch('/people/12');
        $this->assertResponseStatusCode(200);
        $this->assertJson($this->getResponse()->getContent());
    }

}
