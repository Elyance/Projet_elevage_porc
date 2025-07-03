<?php

namespace app\controllers;

use app\models\NourrirModel;
use Flight;

class NourrirController {
    private $nourrirModel;
    private $raceModel;

    public function __construct() {
        $this->nourrirModel = new NourrirModel();
        $this->raceModel = new RaceModel();
    }

    // Affiche le formulaire de nourrissage
    public function index() {
        $races = $this->raceModel->getAllRaces();
        $aliments = (new AlimentModel())->getAllAliments();
        Flight::render('nourrir', ['races' => $races, 'aliments' => $aliments]);
    }

    // Traite le formulaire de nourrissage
    public function nourrir() {
        $id_race = Flight::request()->data->id_race;
        $id_aliment = Flight::request()->data->id_aliment;
        $quantite_kg = Flight::request()->data->quantite_kg;

        try {
            $this->nourrirModel->nourrirPorcs($id_race, $id_aliment, $quantite_kg);
            (new AlimentModel())->updateStock($id_aliment, -$quantite_kg); // Décrémente le stock
            Flight::json(['success' => 'Nourrissage enregistré !']);
        } catch (Exception $e) {
            Flight::json(['error' => $e->getMessage()], 400);
        }
    }
}

?>