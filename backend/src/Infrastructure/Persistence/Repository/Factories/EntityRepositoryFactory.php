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

namespace Backend\Infrastructure\Persistence\Repository\Factories;

/**
 * Description of EntityRepositoryFactory
 *
 * @author cagatay
 */
use Backend\Infrastructure\Persistence\Repository\EntityRepositoryInterface;
use Backend\Exception\InvalidInputException;
use Backend\Exception\ServiceException;

class EntityRepositoryFactory implements EntityRepositoryFactoryInterface {

    protected $config;
    protected $instances = array();

    /**
     * Default constructor for factory
     *
     * @param array $config Repository configuration
     * @return void
     */
    public function __construct(array $config = null) {
        if ($config) {
            $this->config = $config;
        } else {
            $defaultConfig = require __DIR__ . '/../../../../../config/config.php';
            if (!isset($defaultConfig['repositories'])) {
                throw new InvalidInputException('Repositories configuration is not correctly set.');
            }
            $this->config = $defaultConfig['repositories'];
        }
    }

    /**
     * Create service
     *
     * @param string $name Name of repository
     * @return EntityRepositoryInterface
     */
    public function createRepository($name) {
        if (!isset($this->config[$name])) {
            throw new ServiceException('Repository named "' . $name . '" does not exist.');
        }


        $config = $this->config[$name];

        if (!class_exists($config['class'])) {
            throw new ServiceException('Class named "' . $config['class'] . '" does not exist.');
        }

        if (!isset($config['file'])) {
            throw new InvalidInputException('You should specify \'file\' to read data in config.');
        }
        if (!file_exists($config['file'])) {
            throw new InvalidInputException('File not found: ' . $config['file']);
        }
        if (!isset($config['fields']) || !is_array($config['fields'])) {
            throw new InvalidInputException('You should specify \'fields\' array to map CSV fields to object variables.');
        }

        if (!isset($config['hydrate_to_object']) || !class_exists($config['hydrate_to_object']) || !is_subclass_of(new $config['hydrate_to_object'], '\Backend\Model\Entity')) {
            throw new InvalidInputException('You should specify an \'hydrate_to_object\' value including a class name inherited from Entity object.');
        }

        if (isset($this->instances[$name]) && $this->instances[$name] instanceof $config['class']) {
            return $this->instances[$name];
        }

        $instance = new $config['class']($config);
        $this->instances[$name] = $instance;
        return $instance;
    }

}
