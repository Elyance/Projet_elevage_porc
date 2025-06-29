<?php
namespace app\models;

use PDO;

class CycleModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findAll() {
        $stmt = $this->db->query('SELECT c.*, t.poids AS truie_poids FROM bao_cycle_reproduction c JOIN bao_truie t ON c.id_truie = t.id_truie');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare('SELECT c.*, t.poids AS truie_poids FROM bao_cycle_reproduction c JOIN bao_truie t ON c.id_truie = t.id_truie WHERE c.id_cycle_reproduction = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($id_truie, $date_debut_cycle, $date_fin_cycle, $nombre_portee, $id_insemination = null, $etat = 'en cours') {
        $stmt = $this->db->prepare('INSERT INTO bao_cycle_reproduction (id_truie, date_debut_cycle, date_fin_cycle, nombre_portee, id_insemination, etat) VALUES (:id_truie, :date_debut_cycle, :date_fin_cycle, :nombre_portee, :id_insemination, :etat)');
        return $stmt->execute([
            ':id_truie' => $id_truie,
            ':date_debut_cycle' => $date_debut_cycle,
            ':date_fin_cycle' => $date_fin_cycle,
            ':nombre_portee' => $nombre_portee,
            ':id_insemination' => $id_insemination,
            ':etat' => $etat
        ]);
    }

    public function getPrecedentCycle($truieId, $currentId) {
        $stmt = $this->db->prepare('SELECT * FROM bao_cycle_reproduction WHERE id_truie = :id_truie AND id_cycle_reproduction < :current_id ORDER BY date_debut_cycle DESC LIMIT 1');
        $stmt->execute([':id_truie' => $truieId, ':current_id' => $currentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPrevision($truieId, $currentId) {
        $stmt = $this->db->prepare('SELECT AVG(DATEDIFF(date_fin_cycle, date_debut_cycle)) as avg_days, AVG(nombre_portee) as avg_portee FROM bao_cycle_reproduction WHERE id_truie = :id_truie AND nombre_portee IS NOT NULL AND id_cycle_reproduction != :current_id');
        $stmt->execute([':id_truie' => $truieId, ':current_id' => $currentId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return [
            'days' => $result['avg_days'] ?: 115,
            'portee' => $result['avg_portee'] ?: 0
        ];
    }

    public function updateEtat($id_cycle_reproduction, $etat) {
        $stmt = $this->db->prepare('UPDATE bao_cycle_reproduction SET etat = :etat WHERE id_cycle_reproduction = :id_cycle_reproduction');
        return $stmt->execute([':etat' => $etat, ':id_cycle_reproduction' => $id_cycle_reproduction]);
    }
}