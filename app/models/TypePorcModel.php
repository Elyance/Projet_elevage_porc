<?php

namespace app\models;

use Flight;
use PDO;

class TypePorcModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $sql = 'SELECT * FROM TypePorc';
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
        $sql = 'SELECT * FROM TypePorc where id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();

        return $result;
    }

    public function create($nom, $age_min, $age_max, $poids_min, $poids_max, $espace_requis)
    {
        $sql = 'INSERT INTO  TypePorc (nom, age_min , age_max , poids_min , poids_max , espace_requis) VALUES (:nom, :age_min , :age_max , :poids_min , :poids_max , :espace_requis)';
        $stmt = $this->db->prepare($sql);

        try {
            $stmt->execute([
                ':nom' => $nom,
                ':age_min' => $age_min,
                ':age_max' => $age_max,
                ':poids_min' => $poids_min,
                ':poids_max' => $poids_max,
                ':espace_requis' => $espace_requis
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($id, $nom, $age_min, $age_max, $poids_min, $poids_max, $espace_requis)
    {
        $sql = 'UPDATE TypePorc SET nom = :nom , age_min = :age_min , age_max = :age_max , poids_min = :poids_min , poids_max = :poids_max , espace_requis = :espace_requis WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        try {
            $stmt->execute([
                ':nom' => $nom,
                ':age_min' => $age_min,
                ':age_max' => $age_max,
                ':poids_min' => $poids_min,
                ':poids_max' => $poids_max,
                ':espace_requis' => $espace_requis,
                ':id' => $id
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM TypePorc WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        try {
            $stmt->execute([':id' => $id]);
            echo 'Suppression réussie !';
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
