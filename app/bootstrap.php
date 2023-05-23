<?php

namespace App;

use App\Exceptions\NotFound;

session_start();

require_once 'Core/Config/config.php';
require_once 'rb-sqlite.php';
require_once dirname(__DIR__, 1) . '/vendor/autoload.php';

\R::setup('sqlite:./db.sql');

if (!\R::testConnection()) {
    exit('Нет соединения с базой данных');
}

try {
    Core\Route::start();
} catch (NotFound $e) {
    header('HTTP/1.1 404 Not Found');
    header('Status: 404 Not Found');
    header('Location: /404');
}
