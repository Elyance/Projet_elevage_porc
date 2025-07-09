<?php
namespace app\models;

use Flight;
use PDO;

class ReapproModel
{
    public static function addReappro(int $id_aliment, float $quantite_kg): bool
    {
        $conn = Flight::db();
        $query = "SELECT prix_kg FROM bao_aliments WHERE id_aliment = :id_aliment";
        $stmt = $conn->prepare($query);
        $stmt->execute([':id_aliment' => $id_aliment]);
        $prix_kg = $stmt->fetchColumn();

        if ($prix_kg === false) {
            throw new \Exception("Aliment non trouvé");
        }

        $cout_total = $prix_kg * $quantite_kg;
        $query = "INSERT INTO bao_reapprovisionnement_aliments (id_aliment, quantite_kg, cout_total) 
                  VALUES (:id_aliment, :quantite_kg, :cout_total)";
        $stmt = $conn->prepare($query);
        return $stmt->execute([
            ':id_aliment' => $id_aliment,
            ':quantite_kg' => $quantite_kg,
            ':cout_total' => $cout_total
        ]);
    }
}