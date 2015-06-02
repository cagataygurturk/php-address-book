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
 * ConfigurationService is used to get application configuration
 * It merges the internal configuration that normally a user would not touch
 * with the custom configuration defined by the user
 *
 * @author cagatay
 */
class ConfigurationService implements ConfigurationServiceInterface {

    private $config;
    private $defaultConfiguration;

    public function __construct() {
        /*
         * Default configuration is loaded from config directory
         * Even a custom configuration is not set, ConfigurationService always returns the default configuration
         * needed by some internals of the framework
         */
        $this->defaultConfiguration = require __DIR__ . '/../../config/config.php';
        $this->config = $this->defaultConfiguration;
    }

    /**
     * 
     * Returns the configuration
     *
     * @return array
     */
    public function getConfig() {
        return $this->config;
    }

    /**
     * 
     * It sets the configuration for the service
     * When a custom configuration is set, this method merges it with the default one
     *
     * @param array $config Configuration array
     * @return void
     */
    public function setConfig(array $config) {
        /*
         * 
         */
        $this->config = array_merge_recursive($this->defaultConfiguration, $config);
    }

}
