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

    public static function checkData(array $data): array
    {
        $result = [];
        foreach ($data as $key => $value)
        {
            $result[$key] = self::checkInput($value);
        }
        return $result;
    }
}