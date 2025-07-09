<?php
namespace app\models;
use Flight;

class StatAlimentModel
{
    
    private $db;

    public function __construct() {
        $this->db = Flight::db();
    }
    public function getStatsAliments($annee) {
        // $db = Flight::db();
        $sql = "SELECT a.nom_aliment, SUM(r.quantite_kg) AS total_kg
                FROM bao_reapprovisionnement_aliments r
                JOIN aliments a ON a.id_aliment = r.id_aliment
                WHERE EXTRACT(YEAR FROM r.date_reappro) = :annee
                GROUP BY a.nom_aliment
                ORDER BY total_kg DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['annee' => $annee]);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $top = $data ? $data[0] : null;
        return ['data' => $data, 'top' => $top];
    }
}