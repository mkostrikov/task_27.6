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
    '~^/403$~' => [\App\Controllers\ErrorController::class, 'error403'],
    '~^/content$~' => [\App\Controllers\ContentController::class, 'index'],
];