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

namespace FrameworkTest;

/**
 * Description of TestCase
 *
 * @author cagatay
 */
use Framework\Services\ConfigurationService;
use Framework\ServiceManager\ServiceManager;

class TestCase extends \PHPUnit_Framework_TestCase {

    /**
     * Get global service manager
     *
     * @return ServiceManager
     */
    public function getServiceManager() {
        $config = array(
            'service_manager' => array(
                'factories' => array(
                    'FrameworkTest\Helpers\MockService' => 'FrameworkTest\Helpers\MockServiceFactory'
                ),
                'invokables' => array(
                    'FrameworkTest\Helpers\MockService2'
                )
            ),
            'controllers' => array(
                'factories' => array(
                    'MockControllerByFactory' => 'FrameworkTest\Helpers\MockControllerFactory'
                ),
                'invokables' => array(
                    'FrameworkTest\Helpers\MockController' => 'FrameworkTest\Helpers\MockController'
                )
            )
        );
        $configurationService = new ConfigurationService();
        $configurationService->setConfig($config);
        return new ServiceManager($configurationService);
    }

}
