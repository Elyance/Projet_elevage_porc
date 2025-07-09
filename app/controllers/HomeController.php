<?php
namespace app\controllers;

use Flight;
use SessionMiddleware;

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
                'Reproduction' => Flight::get('flight.base_url').'/reproduction',
                'Alimentation' => Flight::get('flight.base_url').'/aliments',
                'Enclos' => Flight::get('flight.base_url').'/enclos',
                'Employés' => Flight::get('flight.base_url').'/employe',
                'Simulation' => Flight::get('flight.base_url').'/simulation',
                'Statistique' => Flight::get('flight.base_url').'/statistique',
                'Sante' => Flight::get('flight.base_url').'/sante'
            ]
        ];

        // Render the home view
        Flight::render('home', $data);
    }
}