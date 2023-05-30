<?php

namespace App\Core\Utils;

class Csrf
{
    public static function create(): string
    {
        $token = sha1((string)random_int(0, 999999)) . sha1((string)random_int(0, 999999));
        $_SESSION['csrf'] = $token;
        return $token;
    }

    public static function validate(array $data):bool
    {
        if (isset($data['csrf']) && $data['csrf'] === $_SESSION['csrf']) {
            return true;
        }
        return false;
    }
}