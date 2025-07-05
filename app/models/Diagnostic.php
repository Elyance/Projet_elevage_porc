<?php

namespace app\models;
use Flight;

class Diagnostic{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll() {
        $query = "SELECT * from bao_diagnostic bd join bao_maladie bm on bm.id_maladie=bd.id_maladie";
        return $this->db->fetchAll($query);
    }

    public function ajouterDiagnostic($data)
    {
        $sql = "INSERT INTO bao_diagnostic (id_maladie,id_enclos,nombre_infecte, date_apparition, date_diagnostic, desc_traitement, statut, prix_traitement)
                VALUES (?, ?, ?,?, ?, ?,?, ?)";
        $params = [
            $data['id_maladie'],
            $data['id_enclos'],
            $data['nombre_infecte'],
            $data['date_apparition'],
            $data['date_diagnostic'],
            $data['desc_traitement'],
            $data['statut'],
            $data['prix_traitement']
        ];
        return $this->db->runQuery($sql, $params);
    }
}