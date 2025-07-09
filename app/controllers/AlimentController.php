<?php
namespace app\controllers;

use app\models\AlimentModel;
use Flight;
use SessionMiddleware;

class AlimentController
{
    public function index()
    {
        $aliments = AlimentModel::getAllAliments();
        Flight::render('aliments/index', [
            'aliments' => $aliments,
            'showSidebar' => true
        ]);
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