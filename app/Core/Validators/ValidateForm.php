<?php

namespace App\Core\Validators;

class ValidateForm
{
    public static function register(array $request): ?array
    {
        if (!(
            isset($request['username']) &&
            isset($request['email']) &&
            isset($request['password']) &&
            isset($request['password2'])
        )) {
            return null;
        }
        $errors = [];
        $errors['username'] =
            Validate::required($request['username']) ??
            Validate::textInput($request['username']) ??
            Validate::isUnique('users', 'username', $request['username']);

        $errors['email'] =
            Validate::required($request['email']) ??
            Validate::email($request['email']) ??
            Validate::isUnique('users', 'email', $request['email']);

        $errors['password'] =
            Validate::required($request['password']) ??
            Validate::password($request['password']);

        $errors['password2'] =
            Validate::required($request['password2']) ??
            Validate::confirmPassword($request['password'], $request['password2']);

        return array_filter($errors);
    }

    public static function login(array $request): ?array
    {
        if (!(isset($request['email']) && isset($request['password']))) {
            return null;
        }
        return $request;
    }
}