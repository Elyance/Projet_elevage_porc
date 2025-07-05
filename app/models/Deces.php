<?php

namespace app\models;
use Flight;
use Exception;

class Deces{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll() {
        $query = "SELECT * from bao_deces";
        return $this->db->fetchAll($query);
    }

    public function findById($id) {
        $query = "SELECT * from bao_deces where id_deces = ?";
        return $this->db->fetchRow($query, [$id]);
    }

    public function addDeces($data)
    {
        $sql = "INSERT INTO bao_deces (id_enclos,nombre_deces, date_deces, cause_deces)
                VALUES (?, ?, ?, ?)";
        $params = [
            $data['id_enclos'],
            $data['nombre_deces'],
            $data['date_deces'],
            $data['cause_deces']
        ];
        return $this->db->runQuery($sql, $params);
    }
    public function deleteDeces($id)
    {
        try {
            $sql = "DELETE FROM bao_deces WHERE id_deces = ?";
            $this->db->runQuery($sql, [$id]);
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function updateDeces($id, $data)
    {
        try {
            $sql = "UPDATE bao_deces
                SET id_enclos = ?, nombre_deces = ?, date_deces = ?, cause_deces = ?
                WHERE id_deces = ?";
            $params = [
                $data['id_enclos'],
                $data['nombre_deces'],
                $data['date_deces'],
                $data['cause_deces'],
                $id
            ];
            $this->db->runQuery($sql, $params);
        } catch (Exception $e) {
            throw $e;
        }
    }
}