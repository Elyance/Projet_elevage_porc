<?php
namespace app\controllers;

use app\models\NaissanceModel;
use app\models\TruieModel;
use app\models\CycleModel;
use app\models\EnclosModel;
use Flight;

class NaissanceController {
    public function add()
    {
        $truieModel = new TruieModel(Flight::db());
        $truies = $truieModel->findAll();
        $cycleModel = new CycleModel(Flight::db());
        $cycles = $cycleModel->findAll();
        $enclosModel = new EnclosModel(Flight::db());
        $enclos = $enclosModel->findAll();

        $cycle_id = $_GET['cycle_id'] ?? null;
        $truie_id = $_GET['truie_id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cycle_id = $_POST['cycle_id'] ?? $cycle_id; // Use pre-set value if not in POST
            $truie_id = $_POST['truie_id'] ?? $truie_id; // Use pre-set value if not in POST
            $nombre_porcs = $_POST['nombre_porcs'];
            $enclos_id = $_POST['enclos_id'];

            $naissanceModel = new NaissanceModel(Flight::db());
            $naissanceModel->create($cycle_id, $truie_id, $nombre_porcs, $enclos_id);

            Flight::redirect('/cycle');
        }

        Flight::render('naissance/add', ['truies' => $truies, 'cycles' => $cycles, 'enclos' => $enclos, 'cycle_id' => $cycle_id, 'truie_id' => $truie_id]);
    }
}