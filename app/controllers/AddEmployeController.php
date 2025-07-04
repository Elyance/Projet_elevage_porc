<?php
namespace app\controllers;

use Flight;

class AddEmployeController
{
    public function index()
    {
        Flight::render("add_employe/index", ["message" => "Placeholder for add employe"]);
    }
}