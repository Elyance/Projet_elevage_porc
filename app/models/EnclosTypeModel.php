<?php

namespace app\models;

class EnclosTypeModel
{
    public static function getAll()
    {
        $stmt = \Flight::db()->query('SELECT * FROM bao_enclos_type WHERE 1=1');

        return $stmt->fetchAll();
    }
}
