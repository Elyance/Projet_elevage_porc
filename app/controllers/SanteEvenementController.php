<?php

namespace app\controllers;

use app\models\SanteEvenement;
use app\models\SanteTypeEvenement;
use app\models\Enclos;
use Exception;
use Flight;
use DateTime;

class SanteEvenementController
{
    public function home()
    {
        Flight::render('test');
    }

    public function findByDate()
    {
        $day = $_GET['day'] ?? null;
        $month = $_GET['month'] ?? null;
        $year = $_GET['year'] ?? null;
        $santeevenement = new SanteEvenement(Flight::db());
        $datestring = sprintf('%04d-%02d-%02d', $year, $month, $day);
        $evenements = $santeevenement->findByDate($datestring);
        Flight::json($evenements);
    }

    public function formAjouterEvenement() {
        $santetypevenement = new SanteTypeEvenement(Flight::db());
        $enclos = new Enclos(Flight::db());
        $data = [
            'santetypevenements' => $santetypevenement->findAll(),
            'enclos' => $enclos->findAll()
        ];
        Flight::render('createEvenement', $data);
    }

    public function ajouterEvenement() {
        $data = Flight::request()->data;
        $santeevenement = new SanteEvenement(Flight::db());
        try {
            $santeevenement->ajouterEvenement($data);
            Flight::redirect('/evenement/add?success=Evenement cree');
        } catch (Exception $th) {
            Flight::redirect('/evenement/add?error=Erreur lors de la creation de l'.'evenement');
        }
    }
}