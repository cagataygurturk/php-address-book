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

namespace Application\Repository;

/**
 * Description of DataReaderInterface
 *
 * @author cagatay
 */
use Application\Model\Entity;

interface RepositoryInterface {

    public function __construct(array $config);

    public function setConfig(array $config);

    public function getAllRows();

    public function findByCriteria(array $criterias, $limit = null);

    public function insert(Entity $object);

    public function delete(array $criterias);
}
