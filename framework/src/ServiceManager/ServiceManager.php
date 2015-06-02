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

namespace Framework\ServiceManager;

/**
 * Description of ServiceManager
 *
 * @author cagatay
 */
use Framework\Services\ConfigurationServiceInterface;

class ServiceManager implements ServiceManagerInterface {

    private $instances = array();
    private $configurationService;

    public function __construct(ConfigurationServiceInterface $configurationService) {
        $this->configurationService = $configurationService;
    }

    private function getConfig() {
        $configuration = $this->configurationService->getConfig();
        return $configuration['service_manager'];
    }

    protected function getFromInvokable($class) {
        return new $class();
    }

    protected function getFromFactory($class) {
        $factory = new $class();
        if (!($factory instanceof FactoryInterface)) {
            throw new \Framework\Exception\ServiceException($class . ' not implements FactoryInterface');
        }
        $object = $factory->getService($this);
        if ($object instanceof $class) {
            throw new \Framework\Exception\ServiceException('Object returned by Factory class is not an instance of ' . $class);
        }
        return $object;
    }

    /**
     * 
     * Returns the service instance by its name, creating it directly or via its factory
     *
     * @param string $serviceName Service name to call
     * @return object
     */
    public function get($serviceName) {

        if ('Configuration' == $serviceName) {
            return $this->configurationService;
        }

        if (isset($this->instances[$serviceName])) {
            return $this->instances[$serviceName]; //Service already created, then return it
        }

        $config = $this->getConfig();
        $invokable_class = null;
        $factory_class = null;

        $object = null;


        if (($k = array_search($serviceName, $config['invokables']))) {
            $invokable_class = $config['invokables'][$k];
        }

        if (isset($config['factories'][$serviceName])) {
            $factory_class = $config['factories'][$serviceName];
        }

        if (!isset($config['invokables'][$serviceName]) && isset($config['aliases'][$serviceName])) {
            if (($k = array_search($config['aliases'][$serviceName], $config['invokables']))) {
                $invokable_class = $config['invokables'][$k];
            }
        }

        if (!isset($config['factories'][$serviceName]) && isset($config['aliases'][$serviceName]) && isset($config['factories'][$config['aliases'][$serviceName]])) {
            $factory_class = $config['factories'][$config['aliases'][$serviceName]];
        }


        if ($invokable_class) {
            $object = $this->getFromInvokable($invokable_class);
        } else if ($factory_class) {
            $object = $this->getFromFactory($factory_class);
        }

        if ($object) {
            $this->instances[$serviceName] = $object;
            return $object;
        }
        throw new \Framework\Exception\ServiceException('Service named ' . $serviceName . ' not found');
    }

}
