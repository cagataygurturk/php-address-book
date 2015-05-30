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

        $testServiceConfig = array_merge_recursive($config, array(
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