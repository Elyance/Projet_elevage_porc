<?php

namespace app\controllers;

use app\models\SanteEvenement;
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
}