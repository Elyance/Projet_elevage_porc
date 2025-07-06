<?php

namespace app\models;
use Flight;

class Symptome {
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll() {
        $query = "SELECT * from bao_symptome";
        return $this->db->fetchAll($query);
    }
}