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

namespace Framework\MVC\Controller;

/**
 * Description of ControllerInterface
 *
 * @author cagatay
 */
use Framework\MVC\Router\Params;
use Framework\MVC\Request\Request;
use Framework\MVC\Response\Response;

abstract class Controller implements ControllerInterface {

    private $params;
    private $request;
    private $response;

    public function setParams(Params $params) {
        $this->params = $params;
    }

    protected function params($id) {
        return $this->params->get($id);
    }

    public function setRequest(Request $request) {
        $this->request = $request;
    }

    /**
     * Get request
     *
     * @return Request
     */
    public function getRequest() {
        return $this->request;
    }

    public function setResponse(Response $response) {
        $this->response = $response;
    }

    /**
     * Get request
     *
     * @return Response
     */
    public function getResponse() {
        return $this->response;
    }

}
