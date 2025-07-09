<?php

namespace app\controllers;

use app\models\Maladie;
use app\models\MaladieSymptome;
use app\models\Enclos;
use app\models\Symptome;
use Exception;
use Flight;
use DateTime;
use SessionMiddleware;

class MaladieController
{
    public function home()
    {
        SessionMiddleware::startSession();
        $maladie = new Maladie(Flight::db());
        $symptome = new MaladieSymptome(Flight::db());
        $content = Flight::view()->fetch('maladie/listMaladie', [
            'maladies' => $maladie->findAll(),
            'symptomes' => $symptome->findAll()
        ]);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function formAddMaladie() {
        SessionMiddleware::startSession();
        $symptome = new Symptome(Flight::db());
        $content = Flight::view()->fetch('maladie/createMaladie', [
            'symptomes' => $symptome->findAll()
        ]);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function addMaladie() {
        $data = Flight::request()->data;
        $maladie = new Maladie(Flight::db());
        try {
            $maladie->ajouterMaladie($data);
            Flight::redirect(BASE_URL.'/maladie/add?success=Evenement cree');
        } catch (Exception $th) {
            Flight::redirect(BASE_URL.'/maladie/add?error='.''.$th);
        }
    }

    public function formUpdateMaladie($id) {
        SessionMiddleware::startSession();
        $maladie = new Maladie(Flight::db());
        $symptome = new Symptome(Flight::db());
        $maladiesymptome = new MaladieSymptome(Flight::db());

        $content = Flight::view()->fetch('maladie/updateMaladie', [
            'maladie' => $maladie->findById($id),
            'symptomes' => $symptome->findAll(),
            'symptomes_maladie' => $maladiesymptome->findByIdMaladie($id)
        ]);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function updateMaladie($id) {
        $data = Flight::request()->data;
        $maladie = new Maladie(Flight::db());
        try {
            $maladie->updateMaladie($id,$data);
            Flight::redirect(BASE_URL.'/maladie?success=Maladie modifie');
        } catch (Exception $th) {
            Flight::redirect(BASE_URL.'/maladie?error=Erreur lors de la modification de la maladie');
        }
    }

    public function deleteMaladie($id) {
        $maladie = new Maladie(Flight::db());
        try {
            $maladie->deleteMaladie($id);
            Flight::redirect(BASE_URL.'/maladie?success=Maladie supprime');
        } catch (\Throwable $th) {
            Flight::redirect(BASE_URL.'/maladie?error=Erreur lors de la suppression de la maladie');
        }
    }
}