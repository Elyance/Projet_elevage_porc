<?php
namespace app\models;

use PDO;

class NaissanceModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($id_cycle_reproduction, $id_truie, $nombre_porcs, $id_enclos) {
        $stmt = $this->db->prepare('INSERT INTO bao_portee (id_truie, id_cycle_reproduction, nombre_porcs, date_naissance) VALUES (:id_truie, :id_cycle_reproduction, :nombre_porcs, CURDATE())');
        $success = $stmt->execute([':id_truie' => $id_truie, ':id_cycle_reproduction' => $id_cycle_reproduction, ':nombre_porcs' => $nombre_porcs]);

        if ($success) {
            $portee_id = $this->db->lastInsertId();
            // Insert into bao_enclos_portee
            $insertEnclosStmt = $this->db->prepare('INSERT INTO bao_enclos_portee (id_enclos, id_portee, quantite_portee, poids_estimation, statut_vente) VALUES (:id_enclos, :id_portee, :quantite_portee, 0, "non possible")');
            $insertEnclosStmt->execute([':id_enclos' => $id_enclos, ':id_portee' => $portee_id, ':quantite_portee' => $nombre_porcs]);

            // Update cycle with actual number of portées and set etat to 'terminée'
            $cycleModel = new CycleModel($this->db);
            $cycleModel->updateEtat($id_cycle_reproduction, 'terminée');
            $updateStmt = $this->db->prepare('UPDATE bao_cycle_reproduction SET nombre_portee = :nombre_portee, date_fin_cycle = CURDATE() WHERE id_cycle_reproduction = :id_cycle_reproduction');
            $updateStmt->execute([':nombre_portee' => $nombre_porcs, ':id_cycle_reproduction' => $id_cycle_reproduction]);
        }

        return $success;
    }
}