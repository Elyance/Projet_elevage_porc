<?php
namespace app\controllers;

use app\models\AlimentModel;
use Flight;
use SessionMiddleware;

class AlimentController
{
    public function index()
    {
        SessionMiddleware::startSession();
        $aliments = AlimentModel::getAllAliments();
        $content = Flight::view()->fetch('aliments/index', ['aliments' => $aliments]);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function show(int $id)
    {
        $aliment = AlimentModel::getAlimentById($id);
        if (!$aliment) {
            Flight::flash()->error('Aliment non trouvé');
            Flight::redirect('/aliments');
            return;
        }
        Flight::render('aliments/details', ['aliment' => $aliment]);
    }
}