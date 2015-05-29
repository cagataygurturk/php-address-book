<?php

error_reporting(E_ALL);

require_once 'vendor/autoload.php';

use Framework\ServiceManager\ServiceManager;

class Bootstrap {

    protected static $serviceManager;

    public static function init() {
        self::$serviceManager = new ServiceManager(array(
            'factories' => array(
                'MockServiceByFactory' => 'FrameworkTest\Helpers\MockServiceFactory'
            ),
            'aliases' => array(
                'MockService' => 'FrameworkTest\Helpers\MockService'
            )
        ));
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
