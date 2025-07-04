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
                'Accueil' => '/',
                'Reproduction' => '/reproduction',
                'Alimentation' => '/alimentation',
                'Animaux' => '/animaux',
                'Enclos' => '/enclos',
                'Employés' => '/employe',
                'Affichages' => '/affichages'
            ]
        ];

        // Render the home view
        Flight::render('home', $data);
    }
}