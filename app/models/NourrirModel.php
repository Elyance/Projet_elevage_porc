<?php
namespace app\models;

use Flight;
use PDO;

class NourrirModel
{
    public static function getInfosNourrissage(int $id_enclos): array
    {
        $conn = Flight::db();
        
        // Get all races in the enclosure (both litters and sows)
        $query = "
            (SELECT 
                ep.id_enclos_portee,
                rp.id_race,
                rp.nom_race,
                rp.besoins_nutritionnels,
                ep.quantite_total,
                'portee' AS source_type
            FROM bao_enclos_portee ep
            JOIN bao_portee p ON ep.id_portee = p.id_portee
            JOIN bao_races_porcs rp ON p.id_race = rp.id_race
            WHERE ep.id_enclos = :id_enclos)
            
            UNION ALL
            
            (SELECT 
                NULL AS id_enclos_portee,
                rp.id_race,
                rp.nom_race,
                rp.besoins_nutritionnels,
                COUNT(t.id_truie) AS quantite_total,
                'truie' AS source_type
            FROM bao_truie t
            JOIN bao_races_porcs rp ON t.id_race = rp.id_race
            WHERE t.id_enclos = :id_enclos
            GROUP BY rp.id_race, rp.nom_race, rp.besoins_nutritionnels)
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
            
            // Create feeding record
            $query = "INSERT INTO bao_alimentation_enclos (id_enclos) VALUES (:id_enclos) RETURNING id_alimentation";
            $stmt = $conn->prepare($query);
            $stmt->execute([':id_enclos' => $id_enclos]);
            $id_alimentation = $stmt->fetchColumn();

            foreach ($aliments as $index => $id_aliment) {
                if (!empty($repartitions[$index])) {
                    foreach ($repartitions[$index] as $target => $quantite) {
                        if ($quantite > 0) {
                            // Determine if target is litter (portee_) or enclosure (enclos_)
                            if (str_starts_with($target, 'portee_')) {
                                $id_enclos_portee = substr($target, 7);
                                $id_enclos_ref = null;
                            } else {
                                $id_enclos_portee = null;
                                $id_enclos_ref = $id_enclos;
                            }

                            $query = "INSERT INTO bao_details_alimentation 
                                    (id_alimentation, id_aliment, quantite_kg, id_enclos_portee, id_enclos) 
                                    VALUES (:id_alimentation, :id_aliment, :quantite_kg, :id_enclos_portee, :id_enclos)";
                            $stmt = $conn->prepare($query);
                            $stmt->execute([
                                ':id_alimentation' => $id_alimentation,
                                ':id_aliment' => $id_aliment,
                                ':quantite_kg' => $quantite,
                                ':id_enclos_portee' => $id_enclos_portee,
                                ':id_enclos' => $id_enclos_ref
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