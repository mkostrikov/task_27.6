<?php

namespace App\Core\Validators;

use App\Core\Utils\Checker;

class ValidateForm
{
    public static function checkRegisterData(array $data): ?array
    {
        if (
            !(
                isset($data['username']) &&
                isset($data['email']) &&
                isset($data['password']) &&
                isset($data['confirm'])
            )
        ) {
            return null;
        }
        return Checker::checkData($data);
    }

    public static function checkLoginData(array $data): ?array
    {
        if (
            !(
                isset($data['email']) &&
                isset($data['password'])
            )
        ) {
            return null;
        }
        return Checker::checkData($data);
    }

    public static function validateRegisterData(array $data): ?array
    {
        $errors = [];
        $errors['username'] =
            Validate::required($data['username']) &&
            Validate::textInput($data['username']);

        $errors['email'] =
            Validate::required($data['email']) &&
            Validate::email($data['email']) &&
            Validate::isUnique('users', 'email', $data['email']);

        $errors['password'] =
            Validate::required($data['password']) &&
            Validate::password($data['password']);

        $errors['confirm'] =
            Validate::required($data['confirm']) &&
            Validate::confirmPassword($data['password'], $data['confirm']);

        return array_filter($errors, function ($field) {
            return !$field;
        }, ARRAY_FILTER_USE_BOTH);
    }
}