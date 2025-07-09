<?php
namespace app\controllers;

use app\models\AlimentModel;
use app\models\NourrirModel;
use app\models\EnclosModel;
use Flight;
use SessionMiddleware;

class NourrirController
{
    public function index(?int $id_enclos = null, ?array $message = null)
    {
        if ($id_enclos === null) {
            $id_enclos = (int)Flight::request()->query->enclos;
        }
        // Convert EnclosModel objects to arrays
        $enclosObjects = EnclosModel::getAll();
        $enclos = array_map(function ($enclo) {
            return [
                'id_enclos' => $enclo->id_enclos,
                'enclos_type' => $enclo->enclos_type,
                'surface' => $enclo->surface
            ];
        }, $enclosObjects);
        $aliments = AlimentModel::getAllAliments();
        $infosNourrissage = $id_enclos ? NourrirModel::getInfosNourrissage($id_enclos) : [];

        Flight::render('aliments/nourrir', [
            'enclos' => $enclos,
            'aliments' => $aliments,
            'infosNourrissage' => $infosNourrissage,
            'selectedEnclos' => $id_enclos,
            'message' => $message
        ]);
    }

    public function nourrir()
    {
        $data = Flight::request()->data;
        $id_enclos = (int)$data->id_enclos;
        $aliments = $data->aliments ?? [];
        $quantites = $data->quantites ?? [];
        $repartitions = $this->parseRepartitions($data);

        // Debug output
        
        
        
        

        try {
            NourrirModel::nourrirEnclos($id_enclos, $aliments, $quantites, $repartitions);
            $message = ['text' => 'Nourrissage enregistré avec succès !', 'type' => 'success'];
        } catch (\Exception $e) {
            $message = ['text' => 'Erreur: ' . $e->getMessage(), 'type' => 'danger'];
        }
        $this->index($id_enclos, $message);
    }

    private function parseRepartitions($data): array
{
    $repartitions = [];
    $rawData = $data->getData(); // Access the underlying array from flight\util\Collection
    // 
            
    // 
    foreach ($rawData as $key => $value) {
        // 

        if (strpos($key, 'repartitions') === 0 && is_array($value)) {
            // 
            // Iterate over the outer array to get aliment indices
            foreach ($value as $alimentIndex => $distributions) {
                // 
                if (is_array($distributions)) {
                    // Iterate over the inner array to get id_enclos_portee and quantity
                    foreach ($distributions as $id_enclos_portee => $quantity) {
                        // 
                        if (is_numeric($quantity)) {
                            // 
                            $repartitions[$alimentIndex][$id_enclos_portee] = (float)$quantity;
                            // 
                        } else {
                            // 
                        }
                    }
                } else {
                    // 
                }
            }
        } else {
            // 
        }
    }
    // 
    return $repartitions;
}
}