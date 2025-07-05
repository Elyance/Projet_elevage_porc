<?php
namespace app\controllers;

use Flight;

class HomeController
{
    /**
     * Displays the homepage with navigation links.
     */
    public function home()
    {
        // Prepare data for the view
        $data = [
            'page' => 'home',
            'title' => 'Gestion Porc - Accueil',
            'links' => [
                'Accueil' => Flight::get('flight.base_url'),
                'Taches' => Flight::get('flight.base_url').'/taches',
                'Reproduction' => Flight::get('flight.base_url').'/reproduction',
                'Alimentation' => Flight::get('flight.base_url').'/alimentation',
                'Animaux' => Flight::get('flight.base_url').'/animaux',
                'Enclos' => Flight::get('flight.base_url').'/enclos',
                'Employés' => Flight::get('flight.base_url').'/employe',
                'Affichages' => Flight::get('flight.base_url').'/affichages'
            ]
        ];

        // Render the home view
        Flight::render('home', $data);
    }
}