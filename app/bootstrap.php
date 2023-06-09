<?php

namespace App;

use App\Core\Exceptions\ForbiddenException;
use App\Core\Exceptions\NotFoundException;

session_start();

require_once 'Core/Config/config.php';
require_once 'rb-sqlite.php';
require_once dirname(__DIR__, 1) . '/vendor/autoload.php';

\R::setup('sqlite:./db.sql');

try {
    Core\Route::start();
} catch (NotFoundException) {
    header('Location: ' . HOST . '404');
} catch (ForbiddenException) {
    header('Location: ' . HOST . '403');
}
