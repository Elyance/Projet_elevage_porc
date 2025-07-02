<?php

namespace app\models;
use Flight;

class SanteEvenement {
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll() {
        $query = "SELECT * from bao_sante_evenement";
        return $this->db->fetchAll($query);
    }

    public function findByDate($date) {
        $query = "SELECT * from bao_sante_evenement se join bao_sante_type_evenement ste on se.id_type_evenement = ste.id_type_evenement where date_evenement = ?";
        return $this->db->fetchAll($query, [$date]);
    }
}