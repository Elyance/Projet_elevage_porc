<?php

namespace app\models;
use Flight;
use Exception;

class Diagnostic{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll() {
        $query = "SELECT * FROM bao_diagnostic bd JOIN bao_maladie bm ON bm.id_maladie = bd.id_maladie";
        return $this->db->fetchAll($query);
    }

    public function findById($id_diagnostic) {
        $query = "SELECT * FROM bao_diagnostic WHERE id_diagnostic = ?";
        return $this->db->fetchRow($query, [$id_diagnostic]);
    }

    public function ajouterDiagnostic($data)
    {
        $sql = "INSERT INTO bao_diagnostic (id_maladie, id_enclos_portee, id_enclos_portee_original, nombre_males_infectes, nombre_femelles_infectes, date_apparition, date_diagnostic, desc_traitement, statut, prix_traitement)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [
            $data['id_maladie'],
            $data['id_enclos_portee'],
            $data['id_enclos_portee_original'] ?? null,
            $data['nombre_males_infectes'],
            $data['nombre_femelles_infectes'],
            $data['date_apparition'],
            $data['date_diagnostic'],
            $data['desc_traitement'] ?? null,
            $data['statut'],
            $data['prix_traitement'] ?? 0.00
        ];
        return $this->db->runQuery($sql, $params);
    }

    public function findByStatus($status)
    {
        $query = "SELECT * FROM bao_diagnostic WHERE statut = ?";
        return $this->db->fetchAll($query, [$status]);
    }

    public function moveToQuarantine($id_diagnostic)
    {
        $diagnostic = $this->findById($id_diagnostic);
        if (!$diagnostic) {
            throw new Exception("Diagnostic non trouvé");
        }
        return [
            'id_diagnostic' => $id_diagnostic,
            'id_enclos_portee_original' => $diagnostic['id_enclos_portee'],
            'nombre_males_infectes' => $diagnostic['nombre_males_infectes'],
            'nombre_femelles_infectes' => $diagnostic['nombre_femelles_infectes']
        ];
    }

    public function startTreatment($id_diagnostic)
    {
        $this->updateStatus($id_diagnostic, 'en traitement');
    }

    public function markSuccess($id_diagnostic)
    {
        $diagnostic = $this->findById($id_diagnostic);
        $id_enclos_portee_quarantine = $diagnostic['id_enclos_portee'];
        $total_infected = $diagnostic['nombre_males_infectes'] + $diagnostic['nombre_femelles_infectes'];
        $id_enclos_portee_original = $diagnostic['id_enclos_portee_original'];

        // Move pigs back to original enclosure
        $this->movePigs($id_enclos_portee_quarantine, $id_enclos_portee_original, $total_infected, $id_diagnostic);

        // Update status
        $this->updateStatus($id_diagnostic, 'reussi');
    }

    public function markFailure($id_diagnostic)
    {
        $this->updateStatus($id_diagnostic, 'echec');
    }

    public function recordDeath($id_diagnostic, $nombre_deces)
    {
        $diagnostic = $this->findById($id_diagnostic);
        $id_enclos_portee = $diagnostic['id_enclos_portee'];

        // Reduce pig count in the enclosure
        $this->reducePigCount($id_enclos_portee, $nombre_deces, $id_diagnostic);

        // Log death in bao_deces
        $sql = "INSERT INTO bao_deces (id_enclos, nombre_deces, date_deces, cause_deces) 
                VALUES ((SELECT id_enclos FROM bao_enclos_portee WHERE id_enclos_portee = ?), ?, ?, ?)";
        $params = [$id_enclos_portee, $nombre_deces, date('Y-m-d'), "Maladie: " . $diagnostic['id_maladie']];
        $this->db->runQuery($sql, $params);
    }

    private function updateStatus($id_diagnostic, $status)
    {
        $sql = "UPDATE bao_diagnostic SET statut = ? WHERE id_diagnostic = ?";
        $this->db->runQuery($sql, [$status, $id_diagnostic]);
    }

    private function updateStatusAndEnclos($id_diagnostic, $status, $id_enclos, $id_enclos_portee_original)
    {
        $sql = "UPDATE bao_diagnostic SET statut = ?, id_enclos_portee = ?, id_enclos_portee_original = ? WHERE id_diagnostic = ?";
        $this->db->runQuery($sql, [$status, $id_enclos, $id_enclos_portee_original, $id_diagnostic]);
    }

    private function movePigs($from_enclos_portee, $to_enclos, $total_moved, $id_diagnostic)
    {
        try {
            echo "on est la";

            // 1. Réduction dans l'enclos source
            $sql = "UPDATE bao_enclos_portee 
                    SET quantite_total = quantite_total - ? 
                    WHERE id_enclos_portee = ?";
            $this->db->runQuery($sql, [$total_moved, $from_enclos_portee]);

            // 2. Insertion ou mise à jour dans l'enclos cible
            $sql = "INSERT INTO bao_enclos_portee (
                        id_enclos, id_portee, quantite_total, poids_estimation, statut_vente, nombre_jour_ecoule
                    ) 
                    VALUES (
                        ?, 
                        (SELECT id_portee FROM bao_enclos_portee WHERE id_enclos_portee = ? LIMIT 1),
                        ?, 
                        (SELECT poids_estimation FROM bao_enclos_portee WHERE id_enclos_portee = ? LIMIT 1),
                        (SELECT statut_vente FROM bao_enclos_portee WHERE id_enclos_portee = ? LIMIT 1),
                        (SELECT nombre_jour_ecoule FROM bao_enclos_portee WHERE id_enclos_portee = ? LIMIT 1)
                    )
                    ON CONFLICT (id_enclos, id_portee) DO UPDATE SET 
                        quantite_total = bao_enclos_portee.quantite_total + EXCLUDED.quantite_total";
            $this->db->runQuery($sql, [
                $to_enclos,
                $from_enclos_portee,
                $total_moved,
                $from_enclos_portee,
                $from_enclos_portee,
                $from_enclos_portee
            ]);

        } catch (\PDOException $e) {
            echo "Erreur lors du déplacement des porcs : " . $e->getMessage();
            // Optionnel : journalisation ou relance d'exception
            // error_log($e->getMessage());
            // throw $e;
        }
    }

    private function reducePigCount($id_enclos_portee, $nombre_deces, $id_diagnostic)
    {
        $sql = "UPDATE bao_enclos_portee 
                SET quantite_total = quantite_total - ? 
                WHERE id_enclos_portee = ?";
        $this->db->runQuery($sql, [$nombre_deces, $id_enclos_portee]);
    }
}