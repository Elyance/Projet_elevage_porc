<?php
namespace app\controllers;

use app\models\EmployeModel;
use Flight;
use SessionMiddleware;

class EmployeController
{
    public function index()
    {
        SessionMiddleware::startSession();
        $employes = EmployeModel::getAll();
        $content = Flight::view()->fetch('employe/index', ['employes' => $employes]);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function congedier($id)
    {
        $date_retirer = date("Y-m-d");
        EmployeModel::updateStatut((int)$id, "congedier", $date_retirer);
        Flight::redirect("/employe");
    }
}