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
 * Description of ServiceManagerInterface
 *
 * @author cagatay
 */
use Framework\Services\ConfigurationServiceInterface;

interface ServiceManagerInterface {

    public function __construct(ConfigurationServiceInterface $configurationService);

    /**
     * 
     * Returns the service instance by its name, creating it directly or via its factory
     *
     * @param string $serviceName Service name to call
     * @return object
     */
    public function get($serviceName);
}
