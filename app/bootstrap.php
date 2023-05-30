<?php

namespace App;

session_start();

require_once 'Core/Config/config.php';
require_once 'rb-sqlite.php';
require_once dirname(__DIR__, 1) . '/vendor/autoload.php';

\R::setup('sqlite:./db.sql');

try {
    Core\Route::start();
} catch (\Exception $e) {
    echo $e->getMessage();
}
