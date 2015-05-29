<?php

error_reporting(E_ALL);

require_once 'vendor/autoload.php';

use Framework\ServiceManager\ServiceManager;
use Framework\Services\ConfigurationService;

class Bootstrap {

    protected static $serviceManager;
    protected static $config;

    protected static function getConfig() {
        if (!self::$config) {
            self::$config = require(__DIR__ . '/../application/config.php');
        }
        return self::$config;
    }

    public static function init() {
        $config = self::getConfig();

        $testServiceConfig = array_merge_recursive($config['service_manager'], array(
            'factories' => array(
                'MockServiceByFactory' => 'FrameworkTest\Helpers\MockServiceFactory'
            ),
            'aliases' => array(
                'MockService' => 'FrameworkTest\Helpers\MockService'
            )
        ));
        $configurationService = new ConfigurationService();
        $configurationService->setConfig($testServiceConfig);
        self::$serviceManager = new ServiceManager($configurationService);
    }

    /**
     * Get global service manager
     *
     * @return ServiceManager
     */
    public static function getServiceManager() {
        return self::$serviceManager;
    }

}

Bootstrap::init();
