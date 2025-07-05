<?php

namespace app\controllers;

use app\models\TypePorcModel;
use Flight;

class TypePorcController
{
    public function __construct() {}

    public function delete()
    {
        $typePorcModel = new TypePorcModel(Flight::db());

        $id = $_GET['id'];
        try {
            $typePorcModel->delete($id);
            Flight::redirect('/typePorc');
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function update()
    {
        $typePorcModel = new TypePorcModel(Flight::db());
        $nom = $_POST['nom'];
        $age_min = $_POST['age_min'];
        $age_max = $_POST['age_max'];
        $poids_min = $_POST['poids_min'];
        $poids_max = $_POST['poids_max'];
        $espace_requis = $_POST['espace_requis'];
        $id = $_POST['id'];

        try {
            $typePorcModel->update($id, $nom, $age_min, $age_max, $poids_min, $poids_max, $espace_requis);
            Flight::redirect('/typePorc');
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function save()
    {
        $nom = $_POST['nom'];
        $age_min = $_POST['age_min'];
        $age_max = $_POST['age_max'];
        $poids_min = $_POST['poids_min'];
        $poids_max = $_POST['poids_max'];
        $espace_requis = $_POST['espace_requis'];

        $typePorcModel = new TypePorcModel(Flight::db());

        try {
            $typePorcModel->create($nom, $age_min, $age_max, $poids_min, $poids_max, $espace_requis);
            echo 'enregistrement reussi';
            Flight::redirect('/typePorc');
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function form()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $typePorcModel = new TypePorcModel(Flight::db());
            $typePorc = $typePorcModel->findById($id);
            $data['typePorc'] = $typePorc;
        }

        $data['page'] = 'typePorc/form';
        Flight::render('template', $data);
    }

    public function list()
    {
        $typePorcModel = new TypePorcModel(Flight::db());
        try {
            $type_porcs = $typePorcModel->findAll();
            $data = ['page' => 'typePorc/index', 'typePorcs' => $type_porcs];
            Flight::render('template', $data);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
