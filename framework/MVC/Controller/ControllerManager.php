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

namespace Framework\MVC\Controller;

/**
 * Description of ControllerManager
 *
 * @author cagatay
 */
use Framework\Services\ConfigurationServiceInterface;
use Framework\ServiceManager\FactoryInterface;
use Framework\ServiceManager\ServiceManagerInterface;

class ControllerManager implements ControllerManagerInterface {

    private $configurationService;
    protected $serviceManager;

    public function __construct(ConfigurationServiceInterface $configurationService, ServiceManagerInterface $serviceManager) {
        $this->configurationService = $configurationService;
        $this->serviceManager = $serviceManager;
    }

    protected function getServiceManager() {
        return $this->serviceManager;
    }

    private function getConfig() {
        $configuration = $this->configurationService->getConfig();
        return $configuration['controllers'];
    }

    /**
     * Get controller by name
     *
     * @return ControllerInterface
     */
    public function get($controllerName) {
        $config = $this->getConfig();
        $object = null;
        if (isset($config['invokables'][$controllerName])) {
            //alias found
            $class = $config['invokables'][$controllerName];
            $object = new $class();
        }

        if (isset($config['factories'][$controllerName])) {

            //factory found
            $class = $config['factories'][$controllerName];
            $factory = new $class();
            if (!($factory instanceof FactoryInterface)) {
                throw new \Framework\Exception\ServiceException($class . ' not implements FactoryInterface');
            }
            $object = $factory->getService($this->getServiceManager());
            if ($object instanceof $class) {
                throw new \Framework\Exception\ServiceException('Object returned by Factory class is not an instance of ' . $class);
            }
        }

        if ($object) {
            $this->instances[$controllerName] = $object;
            return $object;
        }
        throw new \Framework\Exception\ServiceException('Controller named "' . $controllerName . '" not found');
    }

}
