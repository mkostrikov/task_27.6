<?php
namespace App;

session_start();

require_once 'Core/Config/config.php';
require_once dirname(__DIR__, 1) . '/vendor/autoload.php';

Core\Route::start();