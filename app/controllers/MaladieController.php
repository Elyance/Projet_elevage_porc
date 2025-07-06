<?php

namespace app\controllers;

use app\models\Maladie;
use app\models\MaladieSymptome;
use app\models\Enclos;
use app\models\Symptome;
use Exception;
use Flight;
use DateTime;

class MaladieController
{
    public function home()
    {
        $maladie = new Maladie(Flight::db());
        $symptome = new MaladieSymptome(Flight::db());
        $data = [
            'maladies' => $maladie->findAll(),
            'symptomes' => $symptome->findAll()
        ];
        Flight::render('maladie/listMaladie', $data);
    }

    public function formAddMaladie() {
        $symptome = new Symptome(Flight::db());
        Flight::render('maladie/createMaladie', ['symptomes' => $symptome->findAll()]);
    }

    public function addMaladie() {
        $data = Flight::request()->data;
        $maladie = new Maladie(Flight::db());
        try {
            $maladie->ajouterMaladie($data);
            Flight::redirect('/maladie/add?success=Evenement cree');
        } catch (Exception $th) {
            Flight::redirect('/maladie/add?error='.''.$th);
        }
    }

    public function formUpdateMaladie($id) {
    $maladie = new Maladie(Flight::db());
    $symptome = new Symptome(Flight::db());
    $maladiesymptome = new MaladieSymptome(Flight::db());

    Flight::render('maladie/updateMaladie', [
        'maladie' => $maladie->findById($id),
        'symptomes' => $symptome->findAll(),
        'symptomes_maladie' => $maladiesymptome->findByIdMaladie($id)
    ]);
}


    public function updateMaladie($id) {
        $data = Flight::request()->data;
        $maladie = new Maladie(Flight::db());
        try {
            $maladie->updateMaladie($id,$data);
            Flight::redirect('/maladie?success=Maladie modifie');
        } catch (Exception $th) {
            Flight::redirect('/maladie?error=Erreur lors de la modification de la maladie');
        }
    }

    public function deleteMaladie($id) {
        $maladie =new Maladie(Flight::db());
        try {
            $maladie->deleteMaladie($id);
            Flight::redirect('/maladie?success=Maladie supprime');
        } catch (\Throwable $th) {
            Flight::redirect('/maladie?error=Erreur lors de la suppression de la maladie');
        }
    }
}