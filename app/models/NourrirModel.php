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
        
        // DEBUG: Log the input data
        error_log("=== DEBUGGING nourrirEnclos ===");
        error_log("ID Enclos: " . $id_enclos);
        error_log("Aliments: " . print_r($aliments, true));
        error_log("Quantites: " . print_r($quantites, true));
        error_log("Repartitions: " . print_r($repartitions, true));
        
        try {
            $conn->beginTransaction();

            $query = "INSERT INTO bao_alimentation_enclos (id_enclos) VALUES (:id_enclos) RETURNING id_alimentation";
            $stmt = $conn->prepare($query);
            $stmt->execute([':id_enclos' => $id_enclos]);
            $id_alimentation = $stmt->fetchColumn();
            error_log("Created alimentation record with ID: " . $id_alimentation);
            
            if (empty($aliments)) {
                error_log("ERROR: No aliments provided");
                throw new \Exception("Aucun aliment sélectionné");
            }
            
            foreach ($aliments as $index => $id_aliment) {
                error_log("Processing aliment index: $index, ID: $id_aliment");
                if (!empty($repartitions[$index])) {
                    error_log("Repartitions for index $index: " . print_r($repartitions[$index], true));
                    
                    foreach ($repartitions[$index] as $target_key => $quantite) {
                        error_log("Processing target: $target_key, quantity: $quantite");
                        
                        if ($quantite > 0) {
                            $id_enclos_portee = null;
                            $id_enclos_target = null;
                            
                            if (strpos($target_key, 'portee_') === 0) {
                                $id_enclos_portee = (int)str_replace('portee_', '', $target_key);
                                $id_enclos_target = null;
                            } elseif (strpos($target_key, 'enclos_') === 0) {
                                $id_enclos_portee = null;
                                $id_enclos_target = $id_enclos;
                            } else {
                                error_log("WARNING: Unknown target key format: $target_key");
                                continue;
                            }
                            
                            $query = "INSERT INTO bao_details_alimentation 
                                    (id_alimentation, id_aliment, quantite_kg, id_enclos_portee, id_enclos) 
                                    VALUES (:id_alimentation, :id_aliment, :quantite_kg, :id_enclos_portee, :id_enclos)";
                            $stmt = $conn->prepare($query);
                            
                            $params = [
                                ':id_alimentation' => $id_alimentation,
                                ':id_aliment' => $id_aliment,
                                ':quantite_kg' => $quantite,
                                ':id_enclos_portee' => $id_enclos_portee,
                                ':id_enclos' => $id_enclos_target
                            ];
                            
                            error_log("Executing insert with params: " . print_r($params, true));
                            $stmt->execute($params);
                            
                            AlimentModel::updateStock((int)$id_aliment, -(float)$quantite);
                            error_log("Updated stock for aliment $id_aliment by -$quantite");
                        } else {
                            error_log("Skipping zero quantity for target: $target_key");
                        }
                    }
                } else {
                    error_log("WARNING: No repartitions found for aliment index: $index");
                    
                    // Fallback: use total quantity if no repartition specified
                    if (isset($quantites[$index]) && $quantites[$index] > 0) {
                        error_log("Using fallback - total quantity: " . $quantites[$index]);
                        
                        $query = "INSERT INTO bao_details_alimentation 
                                (id_alimentation, id_aliment, quantite_kg, id_enclos_portee, id_enclos) 
                                VALUES (:id_alimentation, :id_aliment, :quantite_kg, NULL, :id_enclos)";
                        $stmt = $conn->prepare($query);
                        $stmt->execute([
                            ':id_alimentation' => $id_alimentation,
                            ':id_aliment' => $id_aliment,
                            ':quantite_kg' => $quantites[$index],
                            ':id_enclos' => $id_enclos
                        ]);
                        
                        AlimentModel::updateStock((int)$id_aliment, -(float)$quantites[$index]);
                        error_log("Fallback insert completed for aliment $id_aliment");
                    }
                }
            }
            
            $conn->commit();
            error_log("Transaction committed successfully");
            return true;
        } catch (\Exception $e) {
            $conn->rollBack();
            error_log("Feeding error: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            throw $e;
        }
    }
}