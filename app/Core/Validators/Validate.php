<?php

namespace App\Core\Validators;

use App\Data\Db\Db;

class Validate
{
    public static function required(?string $value): ?string
    {
        if (empty($value)) {
            return 'Поле должно быть заполнено';
        }
        return null;
    }

    public static function textInput(string $str): ?string
    {
        if (!preg_match(TEXT_REGEXP, $str)) {
            return 'Допустимы символы латинского алфавита, цифры, -, _';
        }
        return null;
    }

    public static function email(string $email): ?string
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Неверный адрес эл. почты';
        }
        return null;
    }

    public static function password(string $password): ?string
    {
        if (!preg_match(PASSWORD_REGEXP, $password)) {
            return 'Пароль должен быть не менее 8 символов, включать хотя бы один символ в нижнем регистре, верхнем регистре, цифру';
        }
        return null;
    }

    public static function confirmPassword(string $password, string $confirmPassword): ?string
    {
        if ($password !== $confirmPassword) {
            return 'Пароли не совпадают';
        }
        return null;
    }

    public static function isUnique(string $table, string $column, $value): ?string
    {
        if (Db::findOne($table, $column, $value) !== null) {
            return 'Уже используется';
        }
        return null;
    }
}