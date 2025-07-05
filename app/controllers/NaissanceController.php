<?php
namespace app\controllers;

use app\models\NaissanceModel;
use app\models\TruieModel;
use app\models\CycleModel;
use app\models\EnclosModel;
use Flight;

class NaissanceController
{
    public function add()
    {
        $truies = TruieModel::getAll();
        $cycles = CycleModel::getAll();
        $enclos = EnclosModel::getAll();

        $cycle_id = $_GET['cycle_id'] ?? null;
        $truie_id = $_GET['truie_id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cycle_id = $_POST['cycle_id'] ?? $cycle_id;
            $truie_id = $_POST['truie_id'] ?? $truie_id;
            $femelle_nait = (int)($_POST['femelle_nait'] ?? 0);
            $male_nait = (int)($_POST['male_nait'] ?? 0);
            $enclos_id = (int)($_POST['enclos_id'] ?? null);

            // Validation de base
            if (!$cycle_id || !$truie_id || !$enclos_id || $femelle_nait < 0 || $male_nait < 0) {
                Flight::redirect('/naissance/add?error=invalid_data');
                return;
            }

            NaissanceModel::create((int)$cycle_id, (int)$truie_id, $femelle_nait, $male_nait, (int)$enclos_id);

            Flight::redirect('/cycle');
        }

        Flight::render('naissance/add', [
            'truies' => $truies,
            'cycles' => $cycles,
            'enclos' => $enclos,
            'cycle_id' => $cycle_id,
            'truie_id' => $truie_id,
            'error' => $_GET['error'] ?? null
        ]);
    }
}