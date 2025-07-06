<?php

namespace app\models;
use Flight;

class Enclos {
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll() {
        $query = "SELECT * from bao_enclos";
        return $this->db->fetchAll($query);
    }
    public function findAllEnclosPortee() {
        $query = "SELECT * from bao_enclos_portee";
        return $this->db->fetchAll($query);
    }
}