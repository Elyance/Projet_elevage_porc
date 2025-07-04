<?php
namespace app\controllers;

use Flight;

class TacheController
{
    public function index()
    {
        Flight::render("tache/index", ["message" => "Placeholder for gestion taches"]);
    }
}