<?php

namespace App\Core\Utils;

class Acl
{
    public static function access(array $roles): bool
    {
        if (!empty($_SESSION['role']) && in_array($_SESSION['role'], $roles, true)) {
            return true;
        }
        return false;
    }
}