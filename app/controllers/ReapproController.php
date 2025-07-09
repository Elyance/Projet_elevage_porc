<?php
namespace app\controllers;

use app\models\ReapproModel;
use app\models\AlimentModel;
use Flight;
use SessionMiddleware;

class ReapproController
{
    public function index(?array $message = null)
    {
        $aliments = AlimentModel::getAllAliments();
        Flight::render('aliments/reappro', ['aliments' => $aliments, 'message' => $message]);
    }

    public function reapprovisionner()
    {
        $data = Flight::request()->data;
        $id_aliment = (int)$data->id_aliment;
        $quantite_kg = (float)$data->quantite_kg;

        try {
            ReapproModel::addReappro($id_aliment, $quantite_kg);
            AlimentModel::updateStock($id_aliment, $quantite_kg);
            $message = ['text' => 'Réapprovisionnement enregistré avec succès !', 'type' => 'Success'];
        } catch (\Exception $e) {
            $message = ['text' => 'Erreur: ' . $e->getMessage(), 'type' => 'Error'];
        }
        $this->index($message);
    }
}