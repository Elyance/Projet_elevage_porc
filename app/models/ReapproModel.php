<?php

namespace app\models;

use Flight;
use PDO;

class ReapproModel {
    private $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    // Enregistre un réapprovisionnement
    public function addReappro($id_aliment, $quantite_kg) {
        // 1. Récupère le prix/kg
        $query = "SELECT prix_kg FROM aliments WHERE id_aliment = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id_aliment]);
        $prix_kg = $stmt->fetchColumn();

        // 2. Calcule le coût total
        $cout_total = $prix_kg * $quantite_kg;

        // 3. Enregistre le réappro
        $query = "
            INSERT INTO reapprovisionnement_aliments (id_aliment, quantite_kg, cout_total)
            VALUES (?, ?, ?)
        ";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id_aliment, $quantite_kg, $cout_total]);
    }
}
?>