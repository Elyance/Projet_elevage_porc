<?php
namespace app\models;

use Flight;
use PDO;

class NourrirModel
{
    public static function getInfosNourrissage(int $id_enclos): array
    {
        $conn = Flight::db();
        $query = "
            SELECT 
                ep.id_enclos_portee,
                rp.id_race,
                rp.nom_race,
                rp.besoins_nutritionnels,
                (ep.quantite_total) AS quantite_total
            FROM bao_enclos_portee ep
            JOIN bao_portee p ON ep.id_portee = p.id_portee
            JOIN bao_races_porcs rp ON p.id_race = rp.id_race
            WHERE ep.id_enclos = :id_enclos
        ";
        $stmt = $conn->prepare($query);
        $stmt->execute([':id_enclos' => $id_enclos]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function nourrirEnclos(int $id_enclos, array $aliments, array $quantites, array $repartitions): bool
    {
        $conn = Flight::db();
        try {
            $conn->beginTransaction();
            $query = "INSERT INTO bao_alimentation_enclos (id_enclos) VALUES (:id_enclos) RETURNING id_alimentation";
            $stmt = $conn->prepare($query);
            $stmt->execute([':id_enclos' => $id_enclos]);
            $id_alimentation = $stmt->fetchColumn();

            foreach ($aliments as $index => $id_aliment) {
                if (!empty($repartitions[$index])) {
                    foreach ($repartitions[$index] as $id_enclos_portee => $quantite) {
                        if ($quantite > 0) {
                            $query = "INSERT INTO bao_details_alimentation 
                                     (id_alimentation, id_aliment, quantite_kg, id_enclos_portee) 
                                     VALUES (:id_alimentation, :id_aliment, :quantite_kg, :id_enclos_portee)";
                            $stmt = $conn->prepare($query);
                            $stmt->execute([
                                ':id_alimentation' => $id_alimentation,
                                ':id_aliment' => $id_aliment,
                                ':quantite_kg' => $quantite,
                                ':id_enclos_portee' => $id_enclos_portee
                            ]);
                            AlimentModel::updateStock((int)$id_aliment, -(float)$quantite);
                        }
                    }
                }
            }
            $conn->commit();
            return true;
        } catch (\Exception $e) {
            $conn->rollBack();
            throw $e;
        }
    }
}