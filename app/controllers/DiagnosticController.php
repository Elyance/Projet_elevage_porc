<?php

namespace app\controllers;

use app\models\Diagnostic;
use app\models\Enclos;
use app\models\Maladie;
use Exception;
use Flight;
use DateTime;

class DiagnosticController
{
    public function home()
    {
        $diagnostic = new Diagnostic(Flight::db());
        Flight::render('listDiagnostic', ['diagnostics' => $diagnostic->findAll()]);
    }

    public function formAddDiagnostic() {
        $maladie = new Maladie(Flight::db());
        $enclos = new Enclos(Flight::db());
        $data = [
            'maladies' => $maladie->findAll(),
            'enclos' => $enclos->findAll()
        ];
        Flight::render('createDiagnostic', $data);
    }

    public function addDiagnostic() {
        $data = Flight::request()->data;
        $diagnostic = new Diagnostic(Flight::db());
        try {
            $diagnostic->ajouterDiagnostic($data);
            Flight::redirect('/diagnostic/add?success=Evenement cree');
        } catch (Exception $th) {
            Flight::redirect('/diagnostic/add?error=Erreur lors de la creation de l'.'evenement');
        }
    }
}