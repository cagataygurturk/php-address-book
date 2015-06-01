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

namespace Backend\Infrastructure\Persistence\Repository;

/**
 * Description of EntityRepository
 *
 * @author cagatay
 */
use Backend\Model\Entity;

interface EntityRepositoryInterface {

    /**
     * Default constructor for factory
     *
     * @param array $config Repository configuration
     * @return void
     */
    public function __construct(array $config);

    /**
     * @return Entity[]
     */
    public function getAllRows();

    /**
     * @return Entity[]
     */
    public function findByCriteria(array $criterias, $limit = null);

    /**
     * @param Entity;
     * @return bool
     */
    public function insert(Entity $object);

    /**
     * @param array
     */
    public function delete(array $criterias);
}
