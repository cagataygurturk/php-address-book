<?php

require __DIR__ . '/../../vendor/autoload.php';


\Framework\MVC\Application::init(require __DIR__ . '/../config/config.php')->run($request);
