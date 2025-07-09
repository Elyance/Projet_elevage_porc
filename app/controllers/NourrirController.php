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
    }

    public function nourrir() {
        SessionMiddleware::startSession();
        $data = Flight::request()->data;
        $id_enclos = (int)$data->enclos;
        $aliments = $data->aliments ?? [];
        $quantites = $data->quantites ?? [];
        $repartitions = $this->parseRepartitions($data);

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
        
        foreach ($rawData as $key => $value) {
            if (strpos($key, 'repartitions') === 0 && is_array($value)) {
                foreach ($value as $alimentIndex => $distributions) {
                    if (is_array($distributions)) {
                        foreach ($distributions as $target => $quantity) {
                            if (is_numeric($quantity)) {
                                $repartitions[$alimentIndex][$target] = (float)$quantity;
                            }
                        }
                    }
                }
            }
        }
        return $repartitions;
    }
}