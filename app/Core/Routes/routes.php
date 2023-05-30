<?php

return [
    '~^/$~' => [\App\Controllers\Home::class, 'index'],
    '~^/auth/register$~' => [\App\Controllers\Auth::class, 'register'],
    '~^/auth/login$~' => [\App\Controllers\Auth::class, 'login'],
    '~^/auth/logout$~' => [\App\Controllers\Auth::class, 'logout'],
    '~^/auth/success$~' => [\App\Controllers\Auth::class, 'success'],
    '~^/vk$~' => [\App\Controllers\VkAuth::class, 'index'],
    '~^/vk/oauth(.*)$~' => [\App\Controllers\VkAuth::class, 'oauth'],
    '~^/dashboard$~' => [\App\Controllers\Dashboard::class, 'index'],
    '~^/404$~' => [\App\Controllers\Error::class, 'error404'],
    '~^/400$~' => [\App\Controllers\Error::class, 'error400'],
    '~^/csrf$~' => [\App\Controllers\Error::class, 'errorCsrf'],
    '~^/error$~' => [\App\Controllers\Error::class, 'error'],


];