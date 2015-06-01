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

use Framework\MVC\ViewModel\JSONViewModel;
/**
 * RESTfulController abstracts REST methods from custom controller
 * It dispatches actions according to the HTTP verb used in the request.
 * For example POST request always are routed to create($data) action of extending Controller class
 * Inspired by ZF2 AbstractRestfulController
 *
 * @author cagatay
 */
use Framework\MVC\Request\Request;

abstract class RESTfulController extends Controller {

    protected function throwError(\Exception $e) {
        $this->getResponse()->setStatusCode($e->getCode());
        return new JSONViewModel(
                array('code' => $e->getCode(),
            'error' => $e->getMessage())
        );
    }

    public function restAction() {
        switch ($this->getRequest()->getMethod()) {
            case Request::METHOD_GET:
                return $this->getAction();

            case Request::METHOD_POST:
                return $this->createAction();

            case Request::METHOD_PUT:
                return $this->updateAction();

            case Request::METHOD_DELETE:
                return $this->deleteAction();

            case Request::METHOD_OPTIONS:
                return $this->optionsAction();

            default :
                throw new \Framework\Exception\MethodNotAllowedHttpException();
        }
    }

    public function optionsAction() {
        
    }

    public function getAction() {
        if (is_callable(array($this, 'get')) && $this->params('id') != null) {
            return call_user_func(array($this, 'get'), $this->params('id'));
        } else if (is_callable(array($this, 'getList')) && $this->params('id') == null) {
            return call_user_func(array($this, 'getList'));
        } else {
            throw new \Framework\Exception\MethodNotAllowedHttpException();
        }
    }

    public function createAction() {
        if (is_callable(array($this, 'create'))) {
            return call_user_func(array($this, 'create'), $this->getRequest()->getPostParams());
        } else {
            throw new \Framework\Exception\MethodNotAllowedHttpException();
        }
    }

    public function updateAction() {
        if (is_callable(array($this, 'update'))) {
            return call_user_func(array($this, 'update'), $this->params('id'));
        } else {
            throw new \Framework\Exception\MethodNotAllowedHttpException();
        }
    }

    public function deleteAction() {
        if (is_callable(array($this, 'delete'))) {
            return call_user_func(array($this, 'delete'), $this->params('id'));
        } else {
            throw new \Framework\Exception\MethodNotAllowedHttpException();
        }
    }

}
