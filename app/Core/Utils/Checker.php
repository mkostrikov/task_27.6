<?php

namespace App\Core\Utils;

class Checker
{
    public static function checkInput(string $data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public static function salt(string $data)
    {
        return md5(self::checkInput($data) . SECRET_WORD);
    }
}