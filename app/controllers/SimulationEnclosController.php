<?php
// filepath: app/controllers/SimulationEnclosController.php
namespace app\controllers;

use app\models\SimulationEnclosModel;
use Flight;
use SessionMiddleware;

class SimulationEnclosController
{
    public static function showForm() {
        Flight::render('simulation/simulation-enclos');
    }
    public static function index() {
        Flight::render('simulation/index');
    }

    public static function simulate() {
        $porcelets = (int)$_POST['porcelets'];
        $porcs = (int)$_POST['porcs'];
        $truies = (int)$_POST['truies'];
        $verrats = (int)($_POST['verrats'] ?? 0);

        $model = new SimulationEnclosModel();
        $result = $model->calculerDimensions($porcelets, $porcs, $truies, $verrats);

        Flight::render('simulation/simulation_enclos_result', ['result' => $result]);
    }
}