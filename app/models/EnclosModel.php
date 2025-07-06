<?php

namespace app\models;

class EnclosModel
{
    public static function delete($id)
    {
        $stmt = \Flight::db()->prepare('DELETE FROM bao_enclos WHERE id_enclos = ?');

        return $stmt->execute([$id]);
    }

    public static function update($id, $enclos_type, $stockage)
    {
        $stmt = \Flight::db()->prepare('UPDATE bao_enclos SET enclos_type = ?, stockage = ? WHERE id_enclos = ?');

        return $stmt->execute([$enclos_type, $stockage, $id]);
    }

    public static function getAll()
    {
        $stmt = \Flight::db()->query('select * from bao_enclos JOIN bao_enclos_type on bao_enclos.enclos_type = bao_enclos_type.id_enclos_type');

        return $stmt->fetchAll();
    }

    public static function create($type_enclos, $stockage)
    {
        $stmt = \Flight::db()->prepare('INSERT INTO bao_enclos(enclos_type, stockage) VALUES (?,?)');

        return $stmt->execute([$type_enclos, $stockage]);
    }

    public static function findByIdJoined($id)
    {
        $stmt = \Flight::db()->prepare('SELECT * FROM bao_enclos_portee ep RIGHT JOIN bao_enclos e ON ep.id_enclos = e.id_enclos JOIN bao_enclos_type et ON et.id_enclos_type = e.enclos_type WHERE e.id_enclos = ?');
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        return $result;
    }

    public static function findById($id)
    {
        $stmt = \Flight::db()->prepare('SELECT * FROM bao_enclos WHERE id_enclos = ?');
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        return $result;
    }
}
