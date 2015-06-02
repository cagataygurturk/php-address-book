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
 * Description of Factory
 *
 * @author cagatay
 */
interface FactoryInterface {

    /**
     * 
     * To create an instance of a service defined in service_manager['factories'] section of the configuration
     * Service Manager invokes this method injecting itself into it.
     * The factory, thus, can create the instance of the service and can call and inject other dependencies
     * of this newly created service
     * 
     *
     * @param ServiceManagerInterface $sm Service Manager (Locator) instance is always injected into factory by the Service Manager itself
     * @return void
     */
    public function getService(ServiceManagerInterface $sm);
}
