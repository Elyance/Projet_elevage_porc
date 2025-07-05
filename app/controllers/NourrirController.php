<?php
namespace app\controllers;

use app\models\AlimentModel;
use app\models\NourrirModel;
use app\models\EnclosModel;
use Flight;

class NourrirController
{
    public function index(?int $id_enclos = null, ?array $message = null)
    {
        if ($id_enclos === null) {
            $id_enclos = (int)Flight::request()->query->enclos;
        }
        $enclos = EnclosModel::getAll();
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
        return $repartitions;
    }
}