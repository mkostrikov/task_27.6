<?php

return [
    '~^/$~' => [\App\Controllers\HomeController::class, 'index'],
    '~^/auth/register$~' => [\App\Controllers\AuthController::class, 'register'],
    '~^/auth/login$~' => [\App\Controllers\AuthController::class, 'login'],
    '~^/auth/logout$~' => [\App\Controllers\AuthController::class, 'logout'],
    '~^/auth/success$~' => [\App\Controllers\AuthController::class, 'success'],
    '~^/vk$~' => [\App\Controllers\VkAuthController::class, 'index'],
    '~^/vk/oauth(.*)$~' => [\App\Controllers\VkAuthController::class, 'oauth'],
    '~^/dashboard$~' => [\App\Controllers\DashboardController::class, 'index'],
    '~^/404$~' => [\App\Controllers\ErrorController::class, 'error404'],
    '~^/400$~' => [\App\Controllers\ErrorController::class, 'error400'],
    '~^/csrf$~' => [\App\Controllers\ErrorController::class, 'errorCsrf'],
    '~^/error$~' => [\App\Controllers\ErrorController::class, 'error'],
    '~^/articles$~' => [\App\Controllers\ArticlesController::class, 'index'],

];