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

namespace Application\MVC\Controller;

/**
 * Description of PeopleController
 *
 * @author cagatay
 */
use Framework\MVC\Controller\RESTfulController;
use Framework\MVC\ViewModel\JSONViewModel;
use Backend\API\PersonService\PersonServiceInterface;
use Application\Exception\NotFoundException;

class PeopleController extends RESTfulController {

    protected $personService;
    protected $allowedMethods = array('GET', 'POST', 'DELETE');

    public function __construct(PersonServiceInterface $personService) {
        $this->personService = $personService;
    }

    /*
     * Responds for route /people/[:id]
     */

    public function get($id) {
        try {

            $people = $this->personService->getPersonById($id);

            if (count($people) == 0) {
                throw new NotFoundException();
            }


            return $people;
        } catch (\Exception $ex) {
            return $this->throwError($ex);
        }
    }

    /*
     * Responds for route /people
     */

    public function getList() {
        try {

            $people = $this->personService->getAllPeople();
            if (count($people) == 0) {
                throw new NotFoundException();
            }
            return $people;
        } catch (\Exception $ex) {
            return $this->throwError($ex);
        }
    }

    /*
     * Responds for route /people, POST request
     */

    public function create($data) {
        try {
            $person = $this->personService->insert($data['name'], $data['phone'], $data['address']);
            $this->getResponse()->setStatusCode(201);
            return new JSONViewModel(
                    array($person)
            );
        } catch (\Exception $ex) {
            return $this->throwError($ex);
        }
    }

    /*
     * Responds for route /people/[:id], DELETE request
     */

    public function delete($id) {
        try {
            if ($this->personService->delete($id)) {
                $this->getResponse()->setStatusCode(204);
                return $this->getResponse()->setContent('');
            } else {
                throw new NotFoundException();
            }
        } catch (\Exception $ex) {
            return $this->throwError($ex);
        }
    }

}
