<?php

namespace app\controllers;

use Flight;
use app\models\Depense;
use SessionMiddleware;

class DepenseController
{
    public function list()
    {
        SessionMiddleware::startSession();
        $date_debut = Flight::request()->query['date_debut'] ?? null;
        $date_fin = Flight::request()->query['date_fin'] ?? null;

        $depenses = Depense::getFiltered($date_debut, $date_fin);
        $total_depense = Depense::getTotal($date_debut, $date_fin);
        $content = Flight::view()->fetch('depense/liste', [
            'depenses' => $depenses,
            'date_debut' => $date_debut ?? '',
            'date_fin' => $date_fin ?? '',
            'total_depense' => $total_depense
        ]);
        Flight::render('template-quixlab', ['content' => $content]);
    }
}