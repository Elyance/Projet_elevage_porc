<?php

namespace app\controllers;

use app\models\AlimentModel;
use Flight;

class AlimentController {
    private $alimentModel;

    public function __construct() {
        $this->alimentModel = new AlimentModel();
    }

    // Page 1 : Liste des aliments
    public function index() {
        $aliments = $this->alimentModel->getAllAliments();
        Flight::render('aliments/index', ['aliments' => $aliments]);
    }

    // Page 2 : Détails d'un aliment
    public function show($id) {
        $aliment = $this->alimentModel->getAlimentById($id);
        if (!$aliment) {
            Flight::halt(404, "Aliment non trouvé");
        }
        Flight::render('aliments/details', ['aliment' => $aliment]);
    }
}
?>