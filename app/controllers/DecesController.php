<?php

namespace app\controllers;

use app\models\Diagnostic;
use app\models\Deces;
use app\models\Enclos;
use app\models\Maladie;
use Exception;
use Flight;
use DateTime;

class DecesController
{
    public function home()
    {
        $decesModel = new Deces(Flight::db());
        $deces = $decesModel->findAll();
        Flight::render('listDeces', ['deces' => $deces]);
    }

    // Formulaire d'ajout
    public function formAddDeces()
    {
        $enclos = new Enclos(Flight::db());
        Flight::render('createDeces', ['enclos' => $enclos->findAll()]); // vue à créer : deces/add.php
    }

    // Enregistrement du décès
    public function addDeces()
    {
        $data = Flight::request()->data;
        $decesModel = new Deces(Flight::db());
        try {
            $decesModel->addDeces($data);
            Flight::redirect('/deces?success=Décès ajouté');
        } catch (Exception $e) {
            Flight::redirect('/deces/add?error=Erreur lors de l\'ajout');
        }
    }

    // Formulaire de modification
    public function formUpdateDeces($id)
    {
        $decesModel = new Deces(Flight::db());
        $enclos = new Enclos(Flight::db());
        $deces = $decesModel->findById($id);
        $data = [
            'deces' => $deces,
            'enclos' => $enclos->findAll()
        ];
        Flight::render('updateDeces', $data);
    }

    // Modification du décès
    public function updateDeces($id)
    {
        $data = Flight::request()->data;
        $decesModel = new Deces(Flight::db());
        try {
            $decesModel->updateDeces($id, $data);
            Flight::redirect('/deces?success=Décès modifié');
        } catch (Exception $e) {
            Flight::redirect("/deces/update/$id?error=Erreur lors de la modification");
        }
    }

    // Suppression
    public function deleteDeces($id)
    {
        $decesModel = new Deces(Flight::db());
        try {
            $decesModel->deleteDeces($id);
            Flight::redirect('/deces?success=Décès supprimé');
        } catch (Exception $e) {
            Flight::redirect('/deces?error=Erreur lors de la suppression');
        }
    }
}