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
            return [
                'status' => 'error',
                'body' => 'Что-то пошло не так, обновите страницу'
            ];
        }

        $errors = ValidateForm::validateRegisterData($checkedUserData);
        if ($errors) {
            return [
                'status' => 'invalid',
                'body' => $errors
            ];
        }

        $user = User::register($checkedUserData);
        if (empty($user)) {
            return [
                'status' => 'error',
                'body' => 'Не удалось зарегистрировать'
            ];
        }
        return ['status' => 'success'];
    }

    public static function login(array $userData): array
    {
        $checkedUserData = ValidateForm::checkLoginData($userData);
        if (empty($checkedUserData)) {
            return [
                'status' => 'error',
                'body' => 'Что-то пошло не так, обновите страницу'
            ];
        }

        $user = User::login($checkedUserData);
        if  (empty($user)) {
            $log = new Logger('logger');
            $log->pushHandler(new StreamHandler('logs.log', Logger::NOTICE));
            $log->notice('Invalid authentication');
            return [
                'status' => 'invalid',
                'body' => 'Incorrect email or password'
            ];
        }
        return [
            'status' => 'success'
        ];
    }
}