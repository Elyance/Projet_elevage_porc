<?php

namespace app\models;
use Flight;

class SanteTypeEvenement {
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll() {
        $query = "SELECT * from bao_sante_type_evenement";
        return $this->db->fetchAll($query);
    }

    public function addTypeEvenement($data) {
        $sql = "INSERT INTO bao_sante_type_evenement (nom_type_evenement,prix)
                VALUES (?, ?)";
        $params = [
            $data['nom_type_evenement'],
            $data['prix']
        ];
        return $this->db->runQuery($sql, $params);
    }

    public function updateTypeEvenement($id, $data)
    {
        $sql = "UPDATE bao_sante_type_evenement SET nom_type_evenement=?, prix=?
                WHERE id_type_evenement=?";
        $params = [
            $data['nom_type_evenement'],
            $data['prix'],
            $id
        ];
        return $this->db->runQuery($sql, $params);
    }

    public function deleteTypeEvenement($id)
    {
        $sql = "DELETE FROM bao_sante_type_evenement WHERE id_type_evenement = ?";
        return $this->db->runQuery($sql,[$id]);
    }

    public function findById($id) {
        $sql = "select * from bao_sante_type_evenement where id_type_evenement = ?";
        return $this->db->fetchRow($sql, [$id]);
    }
}