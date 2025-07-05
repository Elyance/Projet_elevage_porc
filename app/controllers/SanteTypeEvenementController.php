<?php

namespace app\controllers;

use app\models\SanteTypeEvenement;
use app\models\Enclos;
use Exception;
use Flight;
use DateTime;

class SanteTypeEvenementController
{
    public function home()
    {
        $santetypeevenement = new SanteTypeEvenement(Flight::db());
        Flight::render('listTypeEvenement', ['typeevenements' => $santetypeevenement->findAll()]);
    }

    public function formAddTypeEvenement() {
        Flight::render('createTypeEvenement');
    }

    public function addTypeEvenement() {
        $data = Flight::request()->data;
        $santetypeevenement = new SanteTypeEvenement(Flight::db());
        try {
            $santetypeevenement->addTypeEvenement($data);
            Flight::redirect('/typeevenement/add?success=Evenement cree');
        } catch (Exception $th) {
            Flight::redirect('/typeevenement/add?error=Erreur lors de la creation de l'.'evenement');
        }
    }

    public function formUpdateTypeEvenement($id) {
        $santetypeevenement = new SanteTypeEvenement(Flight::db());
        Flight::render('updateTypeEvenement', ['typeevenement' => $santetypeevenement->findById($id)]);
    }

    public function updateTypeEvenement($id) {
        $data = Flight::request()->data;
        $santetypeevenement = new SanteTypeEvenement(Flight::db());
        try {
            $santetypeevenement->updateTypeEvenement($id,$data);
            Flight::redirect('/typeevenement?success=Evenement modifie');
        } catch (Exception $th) {
            Flight::redirect('/typeevenement?error=Erreur lors de la modification de l'.'evenement');
        }
    }

    public function deleteTypeEvenement($id) {
        $typevenement =new SanteTypeEvenement(Flight::db());
        try {
            $typevenement->deleteTypeEvenement($id);
            Flight::redirect('/typeevenement?success=typevenement supprime');
        } catch (\Throwable $th) {
            Flight::redirect('/typeevenement?error=Erreur lors de la suppression de la typevenement');
        }
    }

}