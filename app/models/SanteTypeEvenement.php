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
}