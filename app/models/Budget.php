<?php

namespace app\models;

use Flight;

class Budget
{
    public static function getBudgetParMois($annee = null)
    {
        $conn = Flight::db();
        $sql = 'SELECT * FROM bao_view_budget';
        $params = [];
        if ($annee) {
            $sql .= ' WHERE annee = :annee';
            $params[':annee'] = $annee;
        }
        $sql .= ' ORDER BY annee, mois';
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getBudgetParAn($annee = null)
    {
        $conn = Flight::db();
        $sql = 'SELECT * FROM bao_view_budget_annuel';
        $params = [];
        if ($annee) {
            $sql .= ' WHERE annee = :annee';
            $params[':annee'] = $annee;
        }
        $sql .= ' ORDER BY annee';
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
