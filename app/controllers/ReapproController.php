<?php

namespace app\controllers;

use app\models\NourrirModel;
use Flight;

class ReapproController {
    private $reapproModel;
    private $alimentModel;

    public function __construct() {
        $this->reapproModel = new ReapproModel();
        $this->alimentModel = new AlimentModel();
    }

    // Affiche le formulaire de réappro
    public function index() {
        $aliments = $this->alimentModel->getAllAliments();
        Flight::render('reappro', ['aliments' => $aliments]);
    }

    // Traite le formulaire de réappro
    public function reapprovisionner() {
        $id_aliment = Flight::request()->data->id_aliment;
        $quantite_kg = Flight::request()->data->quantite_kg;

        try {
            $this->reapproModel->addReappro($id_aliment, $quantite_kg);
            $this->alimentModel->updateStock($id_aliment, $quantite_kg); // Incrémente le stock
            Flight::json(['success' => 'Réapprovisionnement enregistré !']);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 400);
        }
    }
}
?>