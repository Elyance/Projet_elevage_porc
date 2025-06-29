<?php
namespace app\controllers;

use app\models\ReproductionModel;
use app\models\TruieModel;
use app\models\CycleModel;
use Flight;

class ReproductionController {
    public function index()
    {
        $reproductionModel = new ReproductionModel(Flight::db());
        $inseminations = $reproductionModel->findAll();

        if (isset($_GET['action']) && isset($_GET['id'])) {
            $id_insemination = $_GET['id'];
            $action = $_GET['action'];
            $resultat = ($action === 'success') ? 'succes' : 'echec';

            $reproductionModel->updateResult($id_insemination, $resultat);

            if ($resultat === 'succes') {
                $cycleModel = new CycleModel(Flight::db());
                $insemination = $reproductionModel->findAll(['id_insemination' => $id_insemination])[0];
                $gestation_period = 115;
                $date_fin_cycle = date('Y-m-d', strtotime($insemination['date_insemination'] . ' + ' . $gestation_period . ' days'));
                $cycleModel->create($insemination['id_truie'], $insemination['date_insemination'], $date_fin_cycle, 0, $id_insemination);
            }

            Flight::redirect('/reproduction');
        }

        Flight::render('reproduction/index', ['inseminations' => $inseminations]);
    }

    public function inseminate()
    {
        $truieModel = new TruieModel(Flight::db());
        $truies = $truieModel->findAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $truie_id = $_POST['truie_id'];
            $date_insemination = $_POST['date_insemination'];

            $reproductionModel = new ReproductionModel(Flight::db());
            $reproductionModel->create($truie_id, $date_insemination);

            Flight::redirect('/reproduction');
        }

        Flight::render('reproduction/inseminate', ['truies' => $truies]);
    }
}