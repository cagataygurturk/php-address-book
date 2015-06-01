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
     * Set Repository
     * 
     *
     * @return void;
     */
    public function setRepositoryService(PersonRepositoryInterface $database);

    /**
     * Get person by given Id
     * Used for related titles
     *
     * @return Person
     */
    public function getPersonById($id);

    /**
     * Get all people
     * 
     *
     * @return Person[]
     */
    public function getAllPeople();

    /**
     * Insert person to the repository
     * 
     * @param string $name Name
     * @param string $phone Telephone 
     * @param string $address Address
     *  
     * @return Person;
     */
    public function insert($name, $phone, $address);

    /**
     * Delete person by id
     * 
     * @param string $id Id
     *  
     * @return bool;
     */
    public function delete($id);
}
