<?php

namespace app\models;

use Flight;
use PDO;

class NourrirModel {
    private $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    // Nourrit un groupe de porcs d'une même race
    public function nourrirPorcs($id_race, $id_aliment, $quantite_totale_kg) {
        // 1. Récupère les porcs à nourrir
        $query = "SELECT id_porc FROM porcs WHERE id_race = ? AND est_en_engraissement = TRUE";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id_race]);
        $porcs = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (empty($porcs)) {
            throw new Exception("Aucun porc trouvé pour cette race en engraissement.");
        }

        // 2. Répartit la quantité par porc
        $quantite_par_porc = $quantite_totale_kg / count($porcs);

        // 3. Enregistre chaque nourrissage
        $query = "INSERT INTO historique_alimentation (id_porc, id_aliment, quantite_kg) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);

        foreach ($porcs as $id_porc) {
            $stmt->execute([$id_porc, $id_aliment, $quantite_par_porc]);
        }

        return true;
    }
}
?>