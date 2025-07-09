<?php
namespace app\controllers;
use app\models\StatAlimentModel;
use app\models\StatVenteModel;
use Flight;
use SessionMiddleware;

class StatAlimentController
{
    public static function index() {
        SessionMiddleware::startSession();
        $content = Flight::view()->fetch('statistique/index');
        Flight::render('template-quixlab', ['content' => $content]);

        // Flight::render('statistique/index');
    }
    public static function showForm() {
        SessionMiddleware::startSession();

        $annee = date('Y');
        $model = new StatAlimentModel();
        $stats = $model->getStatsAliments($annee);
        $venteModel = new StatVenteModel();
        $stats_vente = $venteModel->getStatsVentes($annee);
        $content = Flight::view()->fetch('statistique/stat_aliment_result', [
            'stats' => $stats,
            'annee' => $annee,
            'stats_vente' => $stats_vente,
            'annee_vente' => $annee
        ]);
        Flight::render('template-quixlab', ['content' => $content]);
     
    }


    public static function showStats() {
        SessionMiddleware::startSession();

        $annee = (int)$_POST['annee'];
        $model = new StatAlimentModel();
        $stats = $model->getStatsAliments($annee);
        $venteModel = new StatVenteModel();
        $stats_vente = $venteModel->getStatsVentes($annee);
        $content = Flight::view()->fetch('statistique/stat_aliment_result', [
            'stats' => $stats,
            'annee' => $annee,
            'stats_vente' => $stats_vente,
            'annee_vente' => $annee
        ]
    );
        Flight::render('template-quixlab', ['content' => $content]);

    
    }
}