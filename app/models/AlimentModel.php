<?php

namespace app\models;

use Flight;
use PDO;

class AlimentModel {
    private $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    // Récupère tous les aliments avec leur consommation estimée
    public function getAllAliments() {
        $query = "
            SELECT a.*, 
                   (SELECT COUNT(*) FROM porcs WHERE est_en_engraissement = TRUE) * a.conso_journaliere_kg_par_porc 
                   AS conso_journaliere_totale 
            FROM aliments a
        ";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère un aliment par son ID + historique des réapprovisionnements
    public function getAlimentById($id) {
        $query = "
            SELECT a.*, 
                   r.quantite_kg AS quantite_reappro, 
                   r.date_reappro, 
                   r.cout_total
            FROM aliments a
            LEFT JOIN reapprovisionnement_aliments r ON a.id_aliment = r.id_aliment
            WHERE a.id_aliment = ?
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Met à jour le stock après nourrissage ou réappro
    public function updateStock($id_aliment, $quantite_kg) {
        $query = "UPDATE aliments SET stock_kg = stock_kg + ? WHERE id_aliment = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$quantite_kg, $id_aliment]);
    }
}

?>