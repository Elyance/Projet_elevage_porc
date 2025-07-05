<?php

namespace app\models;
use Flight;

class MaladieSymptome {
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll() {
        $query = "SELECT * from bao_maladie_symptome ms join bao_symptome s on s.id_symptome= ms.id_symptome";
        return $this->db->fetchAll($query);
    }

    public function findByIdMaladie($id) {
        $query = "SELECT * from bao_maladie_symptome ms join bao_symptome s on s.id_symptome= ms.id_symptome where ms.id_maladie = ?";
        return $this->db->fetchAll($query, [$id]);
    }

    public function ajouterMaladieSymptome($data)
    {
        $sql = "INSERT INTO bao_maladie_symptome (id_maladie,id_symptome)
                VALUES (?, ?)";
        $params = [
            $data['id_maladie'],
            $data['id_symptome']
        ];
        return $this->db->runQuery($sql, $params);
    }
}