<?php

namespace App\Core;

define('ROOT', dirname(__DIR__, 3) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);
define('CONTROLLER', APP . 'Controllers' . DIRECTORY_SEPARATOR);
define('CORE', APP . 'Core' . DIRECTORY_SEPARATOR);
define('DATA', APP . 'Data' . DIRECTORY_SEPARATOR);
define('MODEL', APP . 'Models' . DIRECTORY_SEPARATOR);
define('VIEW', APP . 'Views' . DIRECTORY_SEPARATOR);
define('LAYOUT', VIEW . 'Layout' . DIRECTORY_SEPARATOR);
define('ROUTES', CORE . 'Routes' . DIRECTORY_SEPARATOR);
define('TEXT_REGEXP', '/^[A-Za-z0-9-_]+$/');
define('PASSWORD_REGEXP', '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/');
define('SECRET_WORD', 'ohlmCanuogm');
define('REDBEAN_MODEL_PREFIX', '\\App\\Models\\');