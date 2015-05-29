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
use Framework\ServiceManager\FactoryInterface;
use Framework\ServiceManager\ServiceManagerInterface;

class ControllerManagerFactory implements FactoryInterface {

    public function getService(ServiceManagerInterface $sm) {
        $configuration = $sm->get('Configuration');
        return new ControllerManager($configuration, $sm);
    }

}
