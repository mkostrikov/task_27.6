<?php

namespace App\Data\Db;

use App\Models\Entities\User;

class Db
{
    public static function create(string $table, array $properties)
    {
        $bean = \R::dispense($table);
        foreach ($properties as $prop => $value)
        {
            $bean[$prop] = $value;
        }
        return \R::store($bean);
    }

    public static function findOne(string $table, string $column, $value)
    {
        return \R::findOne($table, " $column = ? ", [ $value ]);
    }

    public static function getById($table, $id)
    {
        return \R::load($table, $id);
    }
}