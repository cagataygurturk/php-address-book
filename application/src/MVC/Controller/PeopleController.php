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

    public function __construct(PersonServiceInterface $personService) {
        $this->personService = $personService;
    }

    public function get($id) {
        try {

            $people = $this->personService->searchPersonById($id);

            if (count($people) == 0) {
                throw new NotFoundException();
            }


            return new JSONViewModel(
                    array('people' => $people)
            );
        } catch (\Exception $ex) {
            return $this->throwError($ex);
        }
    }

    public function getList() {
        try {

            $people = $this->personService->getAllPeople();
            if (count($people) == 0) {
                throw new NotFoundException();
            }
            return new JSONViewModel(
                    array('people' => $people)
            );
        } catch (\Exception $ex) {
            return $this->throwError($ex);
        }
    }

}
