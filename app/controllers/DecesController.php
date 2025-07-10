<?php

namespace app\controllers;

use app\models\Diagnostic;
use app\models\Deces;
use app\models\Enclos;
use app\models\Maladie;
use Exception;
use Flight;
use DateTime;
use SessionMiddleware;

class DecesController
{
    public function home()
    {
        SessionMiddleware::startSession();
        $decesModel = new Deces(Flight::db());
        $content = Flight::view()->fetch('deces/listDeces', [
            'deces' => $decesModel->findAll()
        ]);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function formAddDeces()
    {
        SessionMiddleware::startSession();
        $enclos = new Enclos(Flight::db());
        $content = Flight::view()->fetch('deces/createDeces', [
            'enclos' => $enclos->findAll()
        ]);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function addDeces()
    {
        SessionMiddleware::startSession();
        $data = Flight::request()->data;
        $decesModel = new Deces(Flight::db());
        try {
            $decesModel->addDeces($data);
            Flight::redirect(BASE_URL.'/deces?success=Décès ajouté');
        } catch (Exception $e) {
            Flight::redirect(BASE_URL.'/deces/add?error=Erreur lors de l\'ajout');
        }
    }

    public function formUpdateDeces($id)
    {
        SessionMiddleware::startSession();
        $decesModel = new Deces(Flight::db());
        $enclos = new Enclos(Flight::db());
        $content = Flight::view()->fetch('deces/updateDeces', [
            'deces' => $decesModel->findById($id),
            'enclos' => $enclos->findAll()
        ]);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function updateDeces($id)
    {
        SessionMiddleware::startSession();
        $data = Flight::request()->data;
        $decesModel = new Deces(Flight::db());
        try {
            $decesModel->updateDeces($id, $data);
            Flight::redirect(BASE_URL.'/deces?success=Décès modifié');
        } catch (Exception $e) {
            Flight::redirect(BASE_URL."/deces/update/$id?error=Erreur lors de la modification");
        }
    }

    public function deleteDeces($id)
    {
        SessionMiddleware::startSession();
        $decesModel = new Deces(Flight::db());
        try {
            $decesModel->deleteDeces($id);
            Flight::redirect(BASE_URL.'/deces?success=Décès supprimé');
        } catch (Exception $e) {
            Flight::redirect(BASE_URL.'/deces?error=Erreur lors de la suppression');
        }
    }
}