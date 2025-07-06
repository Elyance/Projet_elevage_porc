<?php
namespace app\controllers;

use app\models\NaissanceModel;
use app\models\TruieModel;
use app\models\CycleModel;
use app\models\EnclosModel;
use app\models\RaceModel;
use Flight;

class NaissanceController
{
    public function add()
    {
        $truies = TruieModel::getAll();
        $cycles = CycleModel::getAll();
        $enclos = EnclosModel::getAll();
        $races = RaceModel::getAll(); // Fetch available races

        $cycle_id = $_GET['cycle_id'] ?? null;
        $truie_id = $_GET['truie_id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cycle_id = (int)($_POST['cycle_id'] ?? $cycle_id);
            $truie_id = (int)($_POST['truie_id'] ?? $truie_id);
            $date_naissance = $_POST['date_naissance'] ?? date('Y-m-d');
            $femelle_nait = (int)($_POST['femelle_nait'] ?? 0);
            $male_nait = (int)($_POST['male_nait'] ?? 0);
            $enclos_id = (int)($_POST['enclos_id'] ?? null);
            $id_race = (int)($_POST['id_race'] ?? 1); // Default to 1 (Large White)

            // Enhanced validation: Check if enclos_id exists in available enclosures
            $valid_enclos = array_column($enclos, 'id_enclos');
            if (!$cycle_id || !$truie_id || !$enclos_id || !in_array($enclos_id, $valid_enclos) || $femelle_nait < 0 || $male_nait < 0) {
                Flight::redirect('/naissance/add?error=invalid_data');
                return;
            }

            NaissanceModel::create((int)$cycle_id, (int)$truie_id, $date_naissance, $femelle_nait, $male_nait, (int)$enclos_id, $id_race);

            Flight::redirect('/cycle');
        }

        Flight::render('naissance/add', [
            'truies' => $truies,
            'cycles' => $cycles,
            'enclos' => $enclos,
            'races' => $races,
            'cycle_id' => $cycle_id,
            'truie_id' => $truie_id,
            'error' => $_GET['error'] ?? null
        ]);
    }
}