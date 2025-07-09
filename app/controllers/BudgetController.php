<?php

namespace app\controllers;

use Flight;
use app\models\Budget;

class BudgetController
{
    public function index()
    {
        $annee = Flight::request()->query['annee'] ?? date('Y');
        $budgetParMois = Budget::getBudgetParMois($annee);
        $budgetParAn = Budget::getBudgetParAn();

        // $data = [
        //     'budgetParMois' => $budgetParMois,
        //     'budgetParAn' => $budgetParAn,
        //     'annee' => $annee,
        //     'page' => 'budget/index'
        // ];
        // Flight::render('budget/index', $data);

        $content = Flight::view()->fetch('budget/index', [
            'budgetParMois' => $budgetParMois,
            'budgetParAn' => $budgetParAn,
            'annee' => $annee,

            "links" => [
                "gestion_salaire" => "/salaire",
                "gestion_presence" => "/presence",
                "gestion_taches" => "/tache",
                "add_employe" => "/add_employe"
            ]
        ]);
        Flight::render("template-quixlab", [
            "content" => $content
        ]);
    }
}
