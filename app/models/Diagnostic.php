<?php

namespace app\models;
use Flight;
use app\controllers\EnclosController;
use Exception;

class Diagnostic {
    private $db;

    public function __construct($db) {
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

    public function ajouterDiagnostic($data) {
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

    public function findByStatus($status) {
        $query = "SELECT * FROM bao_diagnostic WHERE statut = ?";
        return $this->db->fetchAll($query, [$status]);
    }

    public function findByStatuses(array $statuses) {
        $placeholders = implode(',', array_fill(0, count($statuses), '?'));
        $query = "SELECT * FROM bao_diagnostic WHERE statut IN ($placeholders)";
        return $this->db->fetchAll($query, $statuses);
    }

    public function moveToQuarantine($id_diagnostic) {
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

    public function startTreatment($id_diagnostic) {
        $this->updateStatus($id_diagnostic, 'en traitement');
    }

    public function markSuccess($id_diagnostic, $id_enclos_destination) {
        $diagnostic = $this->findById($id_diagnostic);
        if (!$diagnostic) {
            throw new Exception("Diagnostic non trouvé");
        }

        if ($id_enclos_destination === null) {
            throw new Exception("Enclos de destination non spécifié");
        }

        $id_enclos_portee_quarantine = $diagnostic['id_enclos_portee'];
        $total_infected = $diagnostic['nombre_males_infectes'] + $diagnostic['nombre_femelles_infectes'];

        $enclosController = new EnclosController();
        $enclosController->movePorteeManually(
            $id_enclos_portee_quarantine,
            $id_enclos_destination,
            $diagnostic['nombre_males_infectes'],
            $diagnostic['nombre_femelles_infectes']
        );

        $this->updateStatusAndEnclos($id_diagnostic, 'reussi', $id_enclos_portee_quarantine, $id_enclos_destination);
    }

    public function markFailure($id_diagnostic) {
        $this->updateStatus($id_diagnostic, 'echec');
    }

    public function recordDeath($id_diagnostic, $male_deces, $female_deces) {
        $diagnostic = $this->findById($id_diagnostic);
        $id_enclos_portee = $diagnostic['id_enclos_portee'];

        // Validate input
        if ($male_deces < 0 || $female_deces < 0) {
            throw new Exception("Le nombre de décès ne peut pas être négatif");
        }
        $total_deces = $male_deces + $female_deces;
        if ($total_deces == 0) {
            throw new Exception("Aucun décès à enregistrer");
        }

        // Fetch the associated portee
        $enclosPortee = $this->getEnclosPortee($id_enclos_portee);
        if (!$enclosPortee || !$enclosPortee['id_portee']) {
            throw new Exception("Aucune portée associée à cet enclos");
        }
        $portee = $this->getPorteeById($enclosPortee['id_portee']);

        // Validate against available males and females
        if ($male_deces > $portee['nombre_males'] || $female_deces > $portee['nombre_femelles']) {
            throw new Exception("Le nombre de décès dépasse les mâles ou femelles disponibles");
        }

        // Reduce pig count in the enclosure
        $this->reducePigCount($id_enclos_portee, $total_deces, $id_diagnostic);

        // Update bao_portee with new male and female counts
        $new_males = $portee['nombre_males'] - $male_deces;
        $new_femelles = $portee['nombre_femelles'] - $female_deces;
        $this->updatePorteeGender($enclosPortee['id_portee'], $new_males, $new_femelles);

        // Log death in bao_deces with separate male and female counts
        $sql = "INSERT INTO bao_deces (id_enclos, male_deces, female_deces, date_deces, cause_deces) 
                VALUES ((SELECT id_enclos FROM bao_enclos_portee WHERE id_enclos_portee = ?), ?, ?, ?, ?)";
        $params = [
            $id_enclos_portee,
            $male_deces,
            $female_deces,
            date('Y-m-d'),
            "Maladie: " . $diagnostic['id_maladie']
        ];
        $this->db->runQuery($sql, $params);
    }

    private function updateStatus($id_diagnostic, $status) {
        $sql = "UPDATE bao_diagnostic SET statut = ? WHERE id_diagnostic = ?";
        $this->db->runQuery($sql, [$status, $id_diagnostic]);
    }

    public function updateStatusAndEnclos($id_diagnostic, $status, $id_enclos_portee_original, $id_enclos_portee_new) {
        $sql = "UPDATE bao_diagnostic SET statut = ?, id_enclos_portee = ?, id_enclos_portee_original = ? WHERE id_diagnostic = ?";
        $this->db->runQuery($sql, [$status, $id_enclos_portee_new, $id_enclos_portee_original, $id_diagnostic]);
    }

    private function movePigs($from_enclos_portee, $to_enclos, $total_moved, $id_diagnostic) {
        $conn = $this->db;
        $conn->beginTransaction();

        try {
            echo $from_enclos_portee;
            $source = $this->getEnclosPortee($from_enclos_portee);
            echo $source['quantite_total']."<br>";
            echo $total_moved;
            if (!$source || $source['quantite_total'] < $total_moved) {
                throw new Exception('Quantité insuffisante dans l\'enclos source');
            }

            $conn->commit();
        } catch (\PDOException $e) {
            $conn->rollBack();
            throw new Exception("Erreur lors du déplacement des porcs : " . $e->getMessage());
        }
    }

    private function reducePigCount($id_enclos_portee, $nombre_deces, $id_diagnostic) {
        $sql = "UPDATE bao_enclos_portee 
                SET quantite_total = quantite_total - ? 
                WHERE id_enclos_portee = ?";
        $this->db->runQuery($sql, [$nombre_deces, $id_enclos_portee]);
    }

    private function getEnclosPortee($id) {
        $stmt = $this->db->prepare("SELECT * FROM bao_enclos_portee WHERE id_enclos_portee = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    private function getEnclosPorteeByEnclosAndPortee($id_enclos, $id_portee) {
        $stmt = $this->db->prepare("SELECT * FROM bao_enclos_portee WHERE id_enclos = ? AND id_portee = ?");
        $stmt->execute([$id_enclos, $id_portee]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    private function getPorteeById($id_portee) {
        $stmt = $this->db->prepare("SELECT * FROM bao_portee WHERE id_portee = ?");
        $stmt->execute([$id_portee]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    private function updatePorteeGender($id_portee, $males, $femelles) {
        $stmt = $this->db->prepare("UPDATE bao_portee SET nombre_males = ?, nombre_femelles = ? WHERE id_portee = ?");
        $stmt->execute([$males, $femelles, $id_portee]);
    }
}