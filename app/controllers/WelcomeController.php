<?php

namespace app\controllers;

use app\models\Truie;
use Flight;

class WelcomeController {
    public function home() {
        Flight::render('welcome', [
            'message' => 'It works!!!',
        ]);
    }

    public function truie() {
        $truies = Truie::getAll();
        Flight::render('truie', [
            'truies' => $truies,
        ]);
    }
}