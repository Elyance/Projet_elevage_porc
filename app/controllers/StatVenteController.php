<?php
namespace app\controllers;
use app\models\StatVenteModel;
use Flight;

class StatVenteController
{
    public static function showForm() {
        Flight::render('statistique/stat_vente_form');
    }
    public static function index() {
        Flight::render('statistique/index');
    }

    public static function showStats() {
        $annee = (int)$_POST['annee'];
        $model = new StatVenteModel();
        $stats = $model->getStatsVentes($annee);
        Flight::render('statistique/stat_vente_result', ['stats' => $stats, 'annee' => $annee]);
    }
}