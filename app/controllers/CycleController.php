<?php
namespace app\controllers;

use app\models\CycleModel;
use app\models\TruieModel;
use SessionMiddleware;
use Flight;

class CycleController
{
    public function index()
    {
        SessionMiddleware::requireAuth();
        $cycles = CycleModel::getAll();
        $content = Flight::view()->fetch('cycle/index', ['cycles' => $cycles]);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function add()
    {
        SessionMiddleware::requireAuth();
        $truies = TruieModel::getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $truie_id = (int)($_POST['truie_id']);
            $date_debut_cycle = $_POST['date_debut_cycle'];
            $date_fin_cycle = $_POST['date_fin_cycle'] ?? null;
            $nombre_males = (int)($_POST['nombre_males'] ?? 0);
            $nombre_femelles = (int)($_POST['nombre_femelles'] ?? 0);

            CycleModel::create($truie_id, $date_debut_cycle, $date_fin_cycle, $nombre_males, $nombre_femelles);

            Flight::redirect('/cycle');
        }
        $content = Flight::view()->fetch('cycle/add', ['truies' => $truies]);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function details($id)
    {
        SessionMiddleware::requireAuth();
        $currentCycle = CycleModel::findById((int)$id);

        if ($currentCycle && $currentCycle->etat !== 'en cours') {
            $currentId = CycleModel::getCurrentCycleForTruie($currentCycle->id_truie);
            if ($currentId) {
                Flight::redirect('/cycle/details/' . $currentId);
                return;
            }
        }

        $truieId = $currentCycle ? $currentCycle->id_truie : 0;
        $precedentCycle = $currentCycle ? CycleModel::getPrecedentTerminatedCycle($truieId) : null;
        $prevision = $currentCycle ? CycleModel::getPrevision($truieId, $currentCycle->id_cycle_reproduction) : ['days' => 115, 'portee' => 0];
        
        $content = Flight::view()->fetch('cycle/details', [
            'currentCycle' => $currentCycle,
            'precedentCycle' => $precedentCycle,
            'prevision' => $prevision
        ]);
        Flight::render('template-quixlab', ['content' => $content]);
    }
}