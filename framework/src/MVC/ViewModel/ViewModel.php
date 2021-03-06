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

namespace Framework\MVC\ViewModel;

/**
 * Description of ViewModel
 *
 * @author cagatay
 */
abstract class ViewModel implements ViewModelInterface {

    protected $data = array();
    protected $contentType = 'text/html';

    public function __construct(array $data = array()) {
        $this->setData($data);
    }

    public function setData(array $array) {
        $this->data = $array;
    }

    public function render() {
        
    }

    public function getContentType() {
        return $this->contentType;
    }

}
