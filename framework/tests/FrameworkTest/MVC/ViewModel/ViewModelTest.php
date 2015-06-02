<?php

namespace FrameworkTest\MVC\ViewModel;

use PHPUnit_Framework_TestCase;

class RouterTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function testJSONViewModel() {
        $jsonViewModel = new \Framework\MVC\ViewModel\JSONViewModel(array('test'));
        $this->assertJson($jsonViewModel->render());
    }

    public function testXMLViewModel() {
        
        $xmlViewModel = new \Framework\MVC\ViewModel\XMLViewModel(array('test' => array('test2')));
        $render = $xmlViewModel->render();
        $this->assertContains('<root>', $render);
        $this->assertContains('<test>', $render);
        $this->assertContains('<test>', $render);
        $this->assertContains('</root>', $render);
    }

}
