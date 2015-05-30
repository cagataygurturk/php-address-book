<?php

/*
 * Copyright (C) 2015 cagatay
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace FrameworkTest\Helpers;

use \PHPUnit_Framework_TestCase;
use \PHPUnit_Framework_ExpectationFailedException;

abstract class AbstractHttpTestCase extends PHPUnit_Framework_TestCase {

    protected $application;

    protected function getAppConfig() {
        return array();
    }

    /**
     * Get Response returned from application
     *
     * @return \Framework\MVC\Response\Response
     */
    public function getResponse() {
        return $this->application->getResponse();
    }

    public function dispatch($url, $method = 'GET', $post = array()) {

        $request = \Framework\MVC\Request\Request::factory(array(
                    'uri' => $url,
                    'method' => $method,
                    'post' => $post
        ));

        $this->application = \Framework\MVC\Application::init($this->getAppConfig())->run($request);
    }

    /**
     * Retrieve the response status code
     *
     * @return int
     */
    protected function getResponseStatusCode() {
        $response = $this->getResponse();
        return $response->getStatusCode();
    }

    /**
     * Assert response status code
     *
     * @param int $code
     */
    public function assertResponseStatusCode($code) {


        $match = $this->getResponseStatusCode();
        if ($code != $match) {
            throw new PHPUnit_Framework_ExpectationFailedException(
            sprintf('Failed asserting response code "%s", actual status code is "%s"', $code, $match)
            );
        }
        $this->assertEquals($code, $match);
    }

    /**
     * Assert not response status code
     *
     * @param int $code
     */
    public function assertNotResponseStatusCode($code) {

        $match = $this->getResponseStatusCode();
        if ($code == $match) {
            throw new PHPUnit_Framework_ExpectationFailedException(
            sprintf('Failed asserting response code was NOT "%s"', $code)
            );
        }
        $this->assertNotEquals($code, $match);
    }

}
