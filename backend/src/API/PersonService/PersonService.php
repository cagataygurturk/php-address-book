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
 * PersonService is the service that operates on Person repository
 * This is a framework agnostic layer so, it does not any framework-specific dependency
 * Its only dependency is a Repository implements RepositoryInterface
 *
 * @author cagatay
 */
use Backend\Infrastructure\Persistence\Repository\PersonRepositoryInterface;
use Backend\Model\Person;

class PersonService implements PersonServiceInterface {

    protected $database;

    /**
     * Set Repository
     * 
     *
     * @return void;
     */
    public function setRepositoryService(PersonRepositoryInterface $database) {
        $this->database = $database;
    }

    /**
     * Get person by given Id
     * Used for related titles
     *
     * @return Person
     */
    public function getPersonById($id) {
        //We do not have
        return $this->database->findByCriteria(array('id' => $id));
    }

    /**
     * Get all people
     * 
     *
     * @return Person[]
     */
    public function getAllPeople() {
        return $this->database->getAllRows();
    }

    /**
     * Insert person to the repository
     * 
     * @param string $name Name
     * @param string $phone Telephone 
     * @param string $address Address
     *  
     * @return Person;
     */
    public function insert($name, $phone, $address) {
        $person = new Person();
        $person->setName($name);
        $person->setPhone($phone);
        $person->setAddress($address);
        $this->database->insert($person);
        return $person;
    }

    /**
     * Delete person by id
     * 
     * @param string $id Id
     *  
     * @return bool;
     */
    public function delete($id) {
        $objectToDelete = $this->database->findByCriteria(array('id' => $id));
        if (isset($objectToDelete[0]) && $objectToDelete[0] instanceof \Backend\Model\Entity) {
            return $this->database->delete(array('id' => $id));
        }
        return false;
    }

}
