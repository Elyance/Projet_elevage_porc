<?php
namespace app\controllers;
use app\models\StatVenteModel;
use Flight;

class StatVenteController
{
    public static function showForm() {
        Flight::render('stat_vente_form');
    }

    public static function showStats() {
        $annee = (int)$_POST['annee'];
        $model = new StatVenteModel();
        $stats = $model->getStatsVentes($annee);
        Flight::render('stat_vente_result', ['stats' => $stats, 'annee' => $annee]);
    }
}