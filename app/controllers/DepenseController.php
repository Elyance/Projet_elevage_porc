<?php

namespace app\controllers;

use Flight;
use app\models\Depense;

class DepenseController
{
    public function list()
    {
        $date_debut = Flight::request()->query['date_debut'] ?? null;
        $date_fin = Flight::request()->query['date_fin'] ?? null;

        $depenses = Depense::getFiltered($date_debut, $date_fin);
        $total_depense = Depense::getTotal($date_debut, $date_fin);

        // $data = [
        //     'depenses' => $depenses,
        //     'date_debut' => $date_debut ?? '',
        //     'date_fin' => $date_fin ?? '',
        //     'total_depense' => $total_depense,
        //     'page' => 'depense/liste'
        // ];
        // Flight::render('depense/liste', $data);


        $content = Flight::view()->fetch('depense/liste', [
            'depenses' => $depenses,
           'date_debut' => $date_debut ?? '',
             'date_fin' => $date_fin ?? '',
            'total_depense' => $total_depense,
            // 'statut' => $statut ?? '',
            
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