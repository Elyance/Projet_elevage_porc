<?php
namespace app\controllers;
use app\models\StatAlimentModel;
use app\models\StatVenteModel;
use Flight;

class StatAlimentController
{
    public static function showForm() {
        $annee = date('Y');
        $model = new StatAlimentModel();
        $stats = $model->getStatsAliments($annee);
        $venteModel = new StatVenteModel();
        $stats_vente = $venteModel->getStatsVentes($annee);
        Flight::render('simulation/stat_aliment_result', [
            'stats' => $stats,
            'annee' => $annee,
            'stats_vente' => $stats_vente,
            'annee_vente' => $annee
        ]);
    }

    public static function showStats() {
        $annee = (int)$_POST['annee'];
        $model = new StatAlimentModel();
        $stats = $model->getStatsAliments($annee);
        $venteModel = new StatVenteModel();
        $stats_vente = $venteModel->getStatsVentes($annee);
        Flight::render('simulation/stat_aliment_result', [
            'stats' => $stats,
            'annee' => $annee,
            'stats_vente' => $stats_vente,
            'annee_vente' => $annee
        ]);
    }
}