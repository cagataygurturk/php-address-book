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
 * Description of RESTfulController
 *
 * @author cagatay
 */
abstract class RESTfulController extends Controller {

    public function getAction() {
        if (is_callable(array($this, 'get'))) {
            return $this->get($this->params('id'));
        } else {
            throw new \Framework\Exception\MethodNotAllowedHttpException();
        }
    }

    public function getListAction() {
        if (is_callable(array($this, 'getList'))) {
            return $this->getList();
        } else {
            throw new \Framework\Exception\MethodNotAllowedHttpException();
        }
    }

    public function updateAction() {
        if (is_callable(array($this, 'update'))) {
            return $this->update($this->params('id'));
        } else {
            throw new \Framework\Exception\MethodNotAllowedHttpException();
        }
    }

    public function deleteAction() {
        if (is_callable(array($this, 'delete'))) {
            return $this->delete($this->params('id'));
        } else {
            throw new \Framework\Exception\MethodNotAllowedHttpException();
        }
    }

}
