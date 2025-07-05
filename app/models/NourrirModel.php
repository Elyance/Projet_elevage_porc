<?php

namespace app\models;

use Flight;
use PDO;

class NourrirModel {
    private $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    // Récupère les informations nécessaires pour le nourrissage par enclos
    public function getInfosNourrissage($id_enclos) {
        $query = "
            SELECT 
                ep.id_enclos_portee,
                rp.id_race,
                rp.nom_race,
                rp.besoins_nutritionnels,
                ep.quantite_males + ep.quantite_femelles as nombre_porcs,
                ep.quantite_males,
                ep.quantite_femelles
            FROM bao_enclos_portee ep
            JOIN bao_portee p ON ep.id_portee = p.id_portee
            JOIN races_porcs rp ON p.id_race = rp.id_race
            WHERE ep.id_enclos = ?
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id_enclos]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Enregistre le nourrissage pour un enclos
    public function nourrirEnclos($id_enclos, $aliments, $quantites, $repartitions) {
        try {
            $this->db->beginTransaction();
            
            // Créer l'enregistrement principal
            $query = "INSERT INTO alimentation_enclos (id_enclos) VALUES (?) RETURNING id_alimentation";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_enclos]);
            $id_alimentation = $stmt->fetchColumn();
            
            // Enregistrer chaque aliment
            foreach ($aliments as $index => $id_aliment) {
                if (!empty($repartitions[$index])) {
                    foreach ($repartitions[$index] as $id_enclos_portee => $quantite) {
                        if ($quantite > 0) {
                            $query = "INSERT INTO details_alimentation 
                                     (id_alimentation, id_aliment, quantite_kg, id_enclos_portee) 
                                     VALUES (?, ?, ?, ?)";
                            $stmt = $this->db->prepare($query);
                            $stmt->execute([
                                $id_alimentation, 
                                $id_aliment, 
                                $quantite, 
                                $id_enclos_portee
                            ]);
                            
                            // Mettre à jour le stock
                            (new AlimentModel())->updateStock($id_aliment, -$quantite);
                        }
                    }
                }
            }
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}