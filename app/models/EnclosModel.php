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

            $result_select = $pstmt->fetchAll(PDO::FETCH_ASSOC);

            return $result_select ?: []; // Retourne un tableau vide si aucun résultat
        } catch (\Throwable $th) {
            error_log('Error in EnclosModel::findAll(): ' . $th->getMessage());
            return []; // Retourne un tableau vide en cas d'erreur
        }
    }

    public function findById($id_enclos)
    {
        $sql = 'SELECT * FROM bao_enclos WHERE id_enclos = :id_enclos';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_enclos' => $id_enclos]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    public function create($enclos_type, $stockage)
    {
        $sql = 'INSERT INTO bao_enclos (enclos_type, stockage) VALUES (:enclos_type, :stockage)';
        $stmt = $this->db->prepare($sql);

        try {
            $stmt->execute([
                ':enclos_type' => $enclos_type,
                ':stockage' => $stockage
            ]);
            return $this->db->lastInsertId();
        } catch (\Throwable $th) {
            error_log('Error in EnclosModel::create(): ' . $th->getMessage());
            throw $th;
        }
    }

    public function update($id_enclos, $enclos_type, $stockage)
    {
        $sql = 'UPDATE bao_enclos SET enclos_type = :enclos_type, stockage = :stockage WHERE id_enclos = :id_enclos';
        $stmt = $this->db->prepare($sql);
        try {
            return $stmt->execute([
                ':enclos_type' => $enclos_type,
                ':stockage' => $stockage,
                ':id_enclos' => $id_enclos
            ]);
        } catch (\Throwable $th) {
            error_log('Error in EnclosModel::update(): ' . $th->getMessage());
            throw $th;
        }
    }

    public function delete($id_enclos)
    {
        $sql = 'DELETE FROM bao_enclos WHERE id_enclos = :id_enclos';
        $stmt = $this->db->prepare($sql);
        try {
            return $stmt->execute([':id_enclos' => $id_enclos]);
        } catch (\Throwable $th) {
            error_log('Error in EnclosModel::delete(): ' . $th->getMessage());
            throw $th;
        }
    }

    // Méthode supplémentaire pour récupérer le type d'enclos
    public function getEnclosType($id_enclos)
    {
        $sql = 'SELECT enclos_type FROM bao_enclos WHERE id_enclos = :id_enclos';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_enclos' => $id_enclos]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['enclos_type'] ?? null;
    }
}