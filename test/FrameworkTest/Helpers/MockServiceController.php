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

namespace FrameworkTest\Helpers;

/**
 * Description of MockServiceController
 *
 * @author cagatay
 */
use Framework\Services\ConfigurationServiceInterface;
use Framework\ServiceManager\ServiceManagerInterface;

class MockServiceController implements ServiceManagerInterface {

    public function __construct(ConfigurationServiceInterface $configurationService) {
        
    }

     private function getConfig() {
        $configuration = $this->configurationService->getConfig();
        return $configuration['service_manager'];
    }

    public function get($serviceName) {

        if ('Configuration' == $serviceName) {
            return $this->configurationService;
        }

        

      

        if (isset($config['aliases'][$serviceName])) {
            //alias found
            $class = $config['aliases'][$serviceName];
            $object = new \Mockable();
        }

        if (isset($config['factories'][$serviceName])) {

            //factory found
            $class = $config['factories'][$serviceName];
            $factory = new $class();
            if (!($factory instanceof FactoryInterface)) {
                throw new \Framework\Exception\ServiceException($class . ' not implements FactoryInterface');
            }
            $object = $factory->getService($this);
            if ($object instanceof $class) {
                throw new \Framework\Exception\ServiceException('Object returned by Factory class is not an instance of ' . $class);
            }
        }

}
