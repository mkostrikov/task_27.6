<?php

return [
    '~^/$~' => [\App\Controllers\Home::class, 'index'],
    '~^/auth/register$~' => [\App\Controllers\Auth::class, 'register'],
    '~^/auth/register/handler$~' => [\App\Controllers\AuthHandler::class, 'register'],
    '~^/auth/login$~' => [\App\Controllers\Auth::class, 'login'],
    '~^/auth/logout$~' => [\App\Controllers\Auth::class, 'logout'],
    '~^/auth/success$~' => [\App\Controllers\Auth::class, 'success'],
    '~^/dashboard$~' => [\App\Controllers\Dashboard::class, 'index'],
    '~^/404$~' => [\App\Controllers\Error::class, 'error404'],


];