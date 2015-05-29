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

namespace Framework\Services;

/**
 * Description of ConfigService
 *
 * @author cagatay
 */
class ConfigurationService implements ConfigurationServiceInterface {

    private $config;
    private $defaultConfiguration;

    public function __construct() {
        $this->defaultConfiguration = require __DIR__ . '/../config.php'; //Internal configuration
        $this->config = $this->defaultConfiguration;
    }

    public function getConfig() {
        return $this->config;
    }

    public function setConfig(array $config) {
        $this->config = array_merge_recursive($this->defaultConfiguration, $config);
    }

}
