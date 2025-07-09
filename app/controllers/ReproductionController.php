<?php
namespace app\controllers;

use app\models\ReproductionModel;
use app\models\TruieModel;
use app\models\CycleModel;
use Flight;
use SessionMiddleware;

class ReproductionController {
    public function index()
    {
        $inseminations = ReproductionModel::getAll();

        if (isset($_GET['action']) && isset($_GET['id'])) {
            $id_insemination = $_GET['id'];
            $action = $_GET['action'];
            $resultat = ($action === 'success') ? 'succes' : 'echec';

            ReproductionModel::updateResult((int)$id_insemination, $resultat);

            if ($resultat === 'succes') {
                $insemination = ReproductionModel::getAll(['id_insemination' => $id_insemination])[0];
                $gestation_period = 115;
                $date_fin_cycle = date('Y-m-d', strtotime($insemination->date_insemination . ' + ' . $gestation_period . ' days'));
                CycleModel::create($insemination->id_truie, $insemination->date_insemination, $date_fin_cycle, 0,0, $id_insemination);
            }

            Flight::redirect('reproduction');
        }

        Flight::render('reproduction/index', ['inseminations' => $inseminations]);
    }

    public function inseminate()
    {
        $truies = TruieModel::getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $truie_id = $_POST['truie_id'];
            $date_insemination = $_POST['date_insemination'];

            ReproductionModel::create((int)$truie_id, $date_insemination);

            Flight::redirect('/reproduction');
        }

        Flight::render('reproduction/inseminate', ['truies' => $truies]);
    }
}