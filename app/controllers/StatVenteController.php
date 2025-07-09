<?php
namespace app\controllers;
use app\models\StatVenteModel;
use Flight;
use SessionMiddleware;

class StatVenteController
{
    public static function showForm() {
        SessionMiddleware::startSession();
        $content = Flight::view()->fetch('statistique/stat_vente_form');
        Flight::render('template-quixlab', ['content' => $content]);

    }
    public static function index() {
        SessionMiddleware::startSession();
        $content = Flight::view()->fetch('statistique/index');
        Flight::render('template-quixlab', ['content' => $content]);

        // Flight::render('statistique/index');
    }

    public static function showStats() {
        SessionMiddleware::startSession();

        $annee = (int)$_POST['annee'];
        $model = new StatVenteModel();
        $stats = $model->getStatsVentes($annee);
        $content = Flight::view()->fetch('statistique/stat_vente_result', ['stats' => $stats, 'annee' => $annee]);

        Flight::render('template-quixlab', ['content' => $content]);
    }
}