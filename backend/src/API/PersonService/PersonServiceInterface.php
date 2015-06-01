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

namespace Backend\API\PersonService;

/**
 * IPersonServicee
 *
 * @author cagatay
 */
use Backend\Infrastructure\Persistence\Repository\PersonRepositoryInterface;
use Backend\Model\Person;

interface PersonServiceInterface {

    /**
     * Get person by given Id
     * Used for related titles
     *
     * @return Person
     */
    public function searchPersonById($id);

    /**
     * Get all people
     * 
     *
     * @return Person[]
     */
    public function getAllPeople();

    /**
     * Set Repository
     * 
     *
     * @return void;
     */
    public function setRepositoryService(PersonRepositoryInterface $database);
}
