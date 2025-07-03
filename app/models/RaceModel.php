<?php

namespace app\models;

use Flight;
use PDO;

class RaceModel {
    private $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    public function getAllRaces() {
        $query = "SELECT id_race, nom_race FROM races_porcs";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
}