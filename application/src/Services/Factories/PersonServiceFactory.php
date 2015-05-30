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

namespace Application\Services\Factories;

/**
 * Why we use this factory class if we already have a Factory in MVC layer that is used for Service Manager?
 * Because this factory is framework-agnostic. Even we are not using any framework, just with a RepositoryInterface
 * we can create a PersonService instance easily
 * 
 * In Application\MVC\Factories\PersonServiceFactory we are extending this factory and implementing framework-specific factory interface
 * to help Service Manager create objects
 *
 * @author cagatay
 */
use Application\Services\PersonService;
use Application\Repository\RepositoryInterface;

class PersonServiceFactory implements FactoryInterface {

    protected $repositoryService;

    public function setRepositoryService(RepositoryInterface $repositoryService) {
        $this->repositoryService = $repositoryService;
    }

    public function createService() {
        if (!$this->repositoryService) {
            throw new \Application\Exception\InvalidInputException('Repository service needed');
        }
        $service = new PersonService();
        $service->setRepositoryService($this->repositoryService);
        return $service;
    }

}
