<?php

namespace App\Core\Handlers;

use App\Core\Validators\ValidateForm;
use App\Models\User;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class AuthHandler
{
    public static function register(array $userData): array
    {
        $checkedUserData = ValidateForm::checkRegisterData($userData);
        if (empty($checkedUserData)) {
            return ['error' => 'Что-то пошло не так, обновите страницу'];
        }

        $errors = ValidateForm::validateRegisterData($checkedUserData);
        if ($errors) {
            return ['errors' => $errors];
        }

        $user = User::register($checkedUserData);
        if (empty($user)) {
            return ['error' => 'Не удалось зарегистрировать'];
        }
        return ['register' => 'success'];
    }

    public static function login(array $userData): array
    {
        $checkedUserData = ValidateForm::checkLoginData($userData);
        if (empty($checkedUserData)) {
            return ['error' => 'Что-то пошло не так, обновите страницу'];
        }

        $user = User::login($checkedUserData);
        if  (empty($user)) {
            $log = new Logger('logger');
            $log->pushHandler(new StreamHandler('logs.log', Logger::NOTICE));
            $log->notice('Ошибка аутентификации');
            return ['error' => 'Неверно указана почта или пароль'];
        }
        return ['login' => 'success'];
    }
}