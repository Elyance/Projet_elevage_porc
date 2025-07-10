<?php

namespace app\controllers;

use app\models\SanteTypeEvenement;
use app\models\Enclos;
use Exception;
use Flight;
use DateTime;
use SessionMiddleware;

class SanteTypeEvenementController
{
    public function home()
    {
        SessionMiddleware::startSession();
        $santetypevenement = new SanteTypeEvenement(Flight::db());
        $content = Flight::view()->fetch('evenement/listTypeEvenement', [
            'typeevenements' => $santetypevenement->findAll()
        ]);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function formAddTypeEvenement() {
        SessionMiddleware::startSession();
        $content = Flight::view()->fetch('evenement/createTypeEvenement');
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function addTypeEvenement() {
        $data = Flight::request()->data;
        $santetypevenement = new SanteTypeEvenement(Flight::db());
        try {
            $santetypevenement->addTypeEvenement($data);
            Flight::redirect(BASE_URL.'/typeevenement/add?success=Evenement cree');
        } catch (Exception $th) {
            Flight::redirect(BASE_URL.'/typeevenement/add?error=Erreur lors de la creation de l'.'evenement');
        }
    }

    public function formUpdateTypeEvenement($id) {
        SessionMiddleware::startSession();
        $santetypevenement = new SanteTypeEvenement(Flight::db());
        $content = Flight::view()->fetch('evenement/updateTypeEvenement', [
            'typeevenement' => $santetypevenement->findById($id)
        ]);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function updateTypeEvenement($id) {
        $data = Flight::request()->data;
        $santetypevenement = new SanteTypeEvenement(Flight::db());
        try {
            $santetypevenement->updateTypeEvenement($id,$data);
            Flight::redirect(BASE_URL.'/typeevenement?success=Evenement modifie');
        } catch (Exception $th) {
            Flight::redirect(BASE_URL.'/typeevenement?error=Erreur lors de la modification de l'.'evenement');
        }
    }

    public function deleteTypeEvenement($id) {
        $typevenement = new SanteTypeEvenement(Flight::db());
        try {
            $typevenement->deleteTypeEvenement($id);
            Flight::redirect(BASE_URL.'/typeevenement?success=typevenement supprime');
        } catch (\Throwable $th) {
            Flight::redirect(BASE_URL.'/typeevenement?error=Erreur lors de la suppression de la typevenement');
        }
    }
}