<?php

namespace app\models;

use Flight;
use PDO;

class EnclosModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $sql = 'SELECT * FROM bao_enclos';
        try {
            $pstmt = $this->db->prepare($sql);
            $pstmt->execute();

            $result_select = $pstmt->fetchAll();

            return $result_select;
        } catch (\Throwable $th) {
            echo 'error: ' . $th->getMessage();
        }
        return null;
    }

    public function findById($id)
    {
        $sql = 'SELECT * FROM bao_enclos where id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();

        return $result;
    }

    public function create($nom, $type, $superficie, $capacite)
    {
        $sql = 'INSERT INTO  bao_enclos (nom, type , superficie , capacite) VALUES (:nom, :type , :superficie , :capacite)';
        $stmt = $this->db->prepare($sql);

        try {
            $stmt->execute([
                ':nom' => $nom,
                ':type' => $type,
                ':superficie' => $superficie,
                ':capacite' => $capacite
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($id, $nom, $type, $superficie, $capacite)
    {
        $sql = 'UPDATE bao_enclos SET nom = :nom , type = :type , superficie = :superficie , capacite = :capacite WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        try {
            $stmt->execute([
                ':nom' => $nom,
                ':type' => $type,
                ':superficie' => $superficie,
                ':capacite' => $capacite,
                ':id' => $id
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM bao_enclos WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        try {
            $stmt->execute([':id' => $id]);
            echo 'Suppression réussie !';
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
