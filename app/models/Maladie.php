<?php

namespace app\models;
use Flight;
use Exception;

class Maladie
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $query = "SELECT * from bao_maladie";
        return $this->db->fetchAll($query);
    }

    public function findById($id)
    {
        $query = "SELECT * from bao_maladie where id_maladie = ?";
        return $this->db->fetchRow($query, [$id]);
    }

    public function ajouterMaladie($data)
    {
        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO bao_maladie (nom_maladie, description, dangerosite) VALUES (?, ?, ?)";
            $params = [
                $data['nom_maladie'],
                $data['description'],
                $data['dangerosite']
            ];
            $this->db->runQuery($sql, $params);

            $idMaladie = $this->db->lastInsertId();

            if (!empty($data['id_symptomes']) && is_array($data['id_symptomes'])) {
                foreach ($data['id_symptomes'] as $idSymptome) {
                    $sqlAssoc = "INSERT INTO bao_maladie_symptome (id_maladie, id_symptome) VALUES (?, ?)";
                    $this->db->runQuery($sqlAssoc, [$idMaladie, $idSymptome]);
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function updateMaladie($id, $data)
    {
        try {
            $this->db->beginTransaction();

            $sql = "UPDATE bao_maladie
                SET nom_maladie = ?, description = ?, dangerosite = ?
                WHERE id_maladie = ?";
            $params = [
                $data['nom_maladie'],
                $data['description'],
                $data['dangerosite'],
                $id
            ];
            $this->db->runQuery($sql, $params);

            $this->db->runQuery("DELETE FROM bao_maladie_symptome WHERE id_maladie = ?", [$id]);

            if (!empty($data['id_symptomes']) && is_array($data['id_symptomes'])) {
                foreach ($data['id_symptomes'] as $idSymptome) {
                    $sqlAssoc = "INSERT INTO bao_maladie_symptome (id_maladie, id_symptome) VALUES (?, ?)";
                    $this->db->runQuery($sqlAssoc, [$id, $idSymptome]);
                }
            }

            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function deleteMaladie($id)
    {
        try {
            $this->db->beginTransaction();
            $this->db->runQuery("DELETE FROM bao_diagnostic WHERE id_maladie = ?", [$id]);
            $this->db->runQuery("DELETE FROM bao_maladie_symptome WHERE id_maladie = ?", [$id]);
            $sql = "DELETE FROM bao_maladie WHERE id_maladie = ?";
            $this->db->runQuery($sql, [$id]);
            $this->db->commit();
        } catch (\Throwable $th) {
            $this->db->rollBack();
            throw $th;
        }

    }


}