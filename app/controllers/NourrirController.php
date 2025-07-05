<?php

namespace app\controllers;

use app\models\AlimentModel;
use app\models\NourrirModel;
use app\models\EnclosModel;
use Flight;

class NourrirController {
    private $nourrirModel;
    private $enclosModel;

    public function __construct() {
        $this->nourrirModel = new NourrirModel();
        $this->enclosModel = new EnclosModel(Flight::db());
    }

    // Affiche le formulaire de nourrissage
    public function index($id_enclos = null, $message = null) {
        // Récupérer l'ID de l'enclos depuis la requête GET si non fourni
        if ($id_enclos === null) {
            $id_enclos = Flight::request()->query->enclos;
        }
    
        $enclos = $this->enclosModel->findAll();
        $aliments = (new AlimentModel())->getAllAliments();
        
        $infosNourrissage = [];
        if ($id_enclos) {
            $infosNourrissage = $this->nourrirModel->getInfosNourrissage($id_enclos);
        }
    
        Flight::render('aliments/nourrir', [
            'enclos' => $enclos,
            'aliments' => $aliments,
            'infosNourrissage' => $infosNourrissage,
            'selectedEnclos' => $id_enclos,
            'message' => $message
        ]);
    }

    // Traite le formulaire de nourrissage
    public function nourrir() {
        $id_enclos = Flight::request()->data->id_enclos;
        $data = Flight::request()->data;
        
        // Initialiser les tableaux
        $aliments = [];
        $quantites = [];
        $repartitions = [];
    
        // Récupération des données du formulaire
        if (isset($data['aliments']) && is_array($data['aliments'])) {
            $aliments = $data['aliments'];
        }
        
        if (isset($data['quantites']) && is_array($data['quantites'])) {
            $quantites = $data['quantites'];
        }
    
        // Construction du tableau de répartition
        foreach ($data as $key => $value) {
            if (strpos($key, 'repartitions') === 0) {
                $parts = explode('[', str_replace(']', '', $key));
                if (count($parts) >= 3) {
                    $index = $parts[1];
                    $id_enclos_portee = $parts[2];
                    $repartitions[$index][$id_enclos_portee] = (float)$value;
                }
            }
        }
    
        try {
            $this->nourrirModel->nourrirEnclos($id_enclos, $aliments, $quantites, $repartitions);
            $message = [
                'text' => 'Nourrissage enregistré avec succès !',
                'type' => 'success'
            ];
        } catch (Exception $e) {
            $message = [
                'text' => 'Erreur: ' . $e->getMessage(),
                'type' => 'danger'
            ];
        }
        
        $this->index($id_enclos, $message);
    }
}