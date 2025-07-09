<?php
namespace app\controllers;

use app\models\AlimentModel;
use app\models\NourrirModel;
use app\models\EnclosModel;
use Flight;
use SessionMiddleware;

class NourrirController {
    public function index(?int $id_enclos = null, ?array $message = null) {
        SessionMiddleware::startSession();
        if ($id_enclos === null) {
            $id_enclos = (int)Flight::request()->query->enclos;
        }
        // Convert EnclosModel objects to arrays
        $enclosObjects = EnclosModel::getAllWithTypeNames();
        $enclos = array_map(function ($enclo) {
            return [
                'id_enclos' => $enclo->id_enclos,
                'enclos_type' => $enclo->enclos_type,
                'type_name' => $enclo->type_name,
                'surface' => $enclo->surface
            ];
        }, $enclosObjects);
        $aliments = AlimentModel::getAllAliments();
        $infosNourrissage = $id_enclos ? NourrirModel::getInfosNourrissage($id_enclos) : [];

        $content = Flight::view()->fetch('aliments/nourrir', [
            'enclos' => $enclos,
            'aliments' => $aliments,
            'infosNourrissage' => $infosNourrissage,
            'selectedEnclos' => $id_enclos,
            'message' => $message
        ]);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function nourrir() {
        SessionMiddleware::startSession();
        $data = Flight::request()->data;
        // DEBUG: Log raw request data
        // error_log("=== RAW REQUEST DATA ===");
        // error_log("POST data: " . print_r($data->getData(), true));
        
        $id_enclos = (int)$data->enclos + 1;
        $aliments = $data->aliments ?? [];
        $quantites = $data->quantites ?? [];
        $repartitions = $this->parseRepartitions($data);
        
        // error_log("=== PARSED DATA ===");
        // error_log("ID Enclos: " . $id_enclos);
        // error_log("Aliments: " . print_r($aliments, true));
        // error_log("Quantites: " . print_r($quantites, true));
        // error_log("Repartitions: " . print_r($repartitions, true));

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
        $rawData = $data->getData();
        // error_log("=== PARSING REPARTITIONS ===");
        // error_log("Raw data keys: " . print_r(array_keys($rawData), true));
        foreach ($rawData as $key => $value) {
            // error_log("Processing key: $key");
            // error_log("Value: " . print_r($value, true));
            if (strpos($key, 'repartitions') === 0) {
                error_log("Found repartitions key: $key");
                
                // Extract the pattern: repartitions[index][target] = quantity
                if (preg_match('/repartitions\[(\d+)\]\[([^\]]+)\]/', $key, $matches)) {
                    $alimentIndex = $matches[1];
                    $target = $matches[2];
                    $quantity = (float)$value;
                    
                    // error_log("Extracted: index=$alimentIndex, target=$target, quantity=$quantity");
                    if ($quantity > 0) {
                        $repartitions[$alimentIndex][$target] = $quantity;
                    }
                }
            }
        }
        // error_log("Final repartitions: " . print_r($repartitions, true));
        return $repartitions;
    }
}