<?php

namespace App\Core\Validators;

use App\Data\Db\Db;

class Validate
{
    public static function required(?string $value): bool
    {
        if (empty($value)) {
            return false;
        }
        return true;
    }

    public static function textInput(string $str): bool
    {
        if (!preg_match(TEXT_REGEXP, $str)) {
            return false;
        }
        return true;
    }

    public static function email(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    public static function password(string $password): bool
    {
        if (!preg_match(PASSWORD_REGEXP, $password)) {
            return false;
        }
        return true;
    }

    public static function confirmPassword(string $password, string $confirmPassword): bool
    {
        if ($password !== $confirmPassword) {
            return false;
        }
        return true;
    }

    public static function isUnique(string $table, string $column, $value): bool
    {
        if (Db::findOne($table, $column, $value) !== null) {
            return false;
        }
        return true;
    }
}