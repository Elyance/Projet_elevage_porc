<?php
namespace app\models;

use Flight;
use PDO;

class AlimentModel
{
    public static function getAllAliments(): array
    {
        $conn = Flight::db();
        $query = "
            SELECT a.*, 
                   (SELECT COALESCE(SUM(quantite_males + quantite_femelles), 0) 
                    FROM bao_enclos_portee 
                    JOIN bao_enclos ON bao_enclos_portee.id_enclos = bao_enclos.id_enclos
                    WHERE bao_enclos.enclos_type IN (3,4)) * a.conso_journaliere_kg_par_porc 
                   AS conso_journaliere_totale 
            FROM aliments a
        ";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAlimentById(int $id): ?array
    {
        $conn = Flight::db();
        $query = "
            SELECT a.*, 
                   r.quantite_kg AS quantite_reappro, 
                   r.date_reappro, 
                   r.cout_total
            FROM aliments a
            LEFT JOIN reapprovisionnement_aliments r ON a.id_aliment = r.id_aliment
            WHERE a.id_aliment = :id
        ";
        $stmt = $conn->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function updateStock(int $id_aliment, float $quantite_kg): bool
    {
        $conn = Flight::db();
        $query = "UPDATE aliments SET stock_kg = stock_kg + :quantite_kg WHERE id_aliment = :id_aliment";
        $stmt = $conn->prepare($query);
        return $stmt->execute([':quantite_kg' => $quantite_kg, ':id_aliment' => $id_aliment]);
    }
}