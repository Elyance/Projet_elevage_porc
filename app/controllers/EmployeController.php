<?php
namespace app\controllers;

use app\models\EmployeModel;
use Flight;
use SessionMiddleware;

class EmployeController
{
    public function index()
    {
        $employes = EmployeModel::getAll();
        Flight::render("employe/index", [
            "employes" => $employes,
            "links" => [
                "gestion_salaire" => "/salaire",
                "gestion_presence" => "/presence",
                "gestion_taches" => "/tache",
                "add_employe" => "/add_employe"
            ]
        ]);
    }

    public function congedier($id)
    {
        $date_retirer = date("Y-m-d");
        EmployeModel::updateStatut((int)$id, "congedier", $date_retirer);
        Flight::redirect("/employe");
    }
}