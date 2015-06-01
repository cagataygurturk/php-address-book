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

namespace Backend\Model;

/**
 * Entity is an abstract class that represents a row in the data source
 *
 * @author cagatay
 */
abstract class Entity {
    /*
     * When flag is true, when new entity is created an UUID will be automatically created
     * @var bool
     */

    protected $generate_id = true;
    protected $id;

    public function __construct() {
        if ($this->generate_id) {
            $this->setId($this->createId());
        }
    }

    public function getId() {
        return (is_numeric($this->id) ? intval($this->id) : $this->id);
    }

    public function setId($id) {
        $this->id = $id;
    }

    protected function createId() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

}
