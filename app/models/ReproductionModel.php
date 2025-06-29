<?php
namespace app\models;

use PDO;

class ReproductionModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findAll() {
        $stmt = $this->db->query('SELECT i.*, t.poids AS truie_poids FROM bao_insemination i JOIN bao_truie t ON i.id_truie = t.id_truie');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($id_truie, $date_insemination) {
        $stmt = $this->db->prepare('INSERT INTO bao_insemination (id_truie, date_insemination, resultat) VALUES (:id_truie, :date_insemination, :resultat)');
        return $stmt->execute([':id_truie' => $id_truie, ':date_insemination' => $date_insemination, ':resultat' => 'en cours']);
    }

    public function updateResult($id_insemination, $resultat) {
        $stmt = $this->db->prepare('UPDATE bao_insemination SET resultat = :resultat WHERE id_insemination = :id_insemination');
        return $stmt->execute([':resultat' => $resultat, ':id_insemination' => $id_insemination]);
    }
}