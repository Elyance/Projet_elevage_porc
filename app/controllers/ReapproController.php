<?php

namespace app\controllers;

use app\models\AlimentModel;
use app\models\ReapproModel;
use Flight;

class ReapproController {
    private $reapproModel;
    private $alimentModel;

    public function __construct() {
        $this->reapproModel = new ReapproModel();
        $this->alimentModel = new AlimentModel();
    }

    // Affiche le formulaire de réappro
    public function index($message = null) {
        $aliments = $this->alimentModel->getAllAliments();
        Flight::render('aliments/reappro', ['aliments' => $aliments, 'message' => $message]);
    }

    // Traite le formulaire de réappro
    public function reapprovisionner() {
        $id_aliment = Flight::request()->data->id_aliment;
        $quantite_kg = Flight::request()->data->quantite_kg;
    
        try {
            $this->reapproModel->addReappro($id_aliment, $quantite_kg);
            $this->alimentModel->updateStock($id_aliment, $quantite_kg);
            $message['text'] = 'Réapprovisionnement enregistré avec succès !';
            $message['type'] = 'Success';
        } catch (Exception $e) {
            $message = 'Erreur: ' . $e->getMessage();
            $message['type'] = 'Error';
        }
        $this->index($message);
    }
}
?>