<?php

namespace app\controllers;

use app\models\EnclosModel;
use Flight;

class EnclosController
{
    public function __construct() {}

    public function delete()
    {
        $enclosModel = new EnclosModel(Flight::db());

        $id = $_GET['id'];
        try {
            $enclosModel->delete($id);
            Flight::redirect('/enclos');
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function update()
    {
        $enclosModel = new EnclosModel(Flight::db());
        $nom = $_POST['nom'];
        $type = $_POST['type'];
        $superficie = $_POST['superficie'];
        $capacite = $_POST['capacite'];
        $id = $_POST['id'];

        try {
            $enclosModel->update($id, $nom, $type, $superficie, $capacite);
            Flight::redirect('/enclos');
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function save()
    {
        $nom = $_POST['nom'];
        $type = $_POST['type'];
        $superficie = $_POST['superficie'];
        $capacite = $_POST['capacite'];

        $enclosModel = new EnclosModel(Flight::db());

        try {
            $enclosModel->create($nom, $type, $superficie, $capacite);
            echo 'enregistrement reussi';
            Flight::redirect('/enclos');
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function form()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $enclosModel = new EnclosModel(Flight::db());
            $enclo = $enclosModel->findById($id);
            $data['enclo'] = $enclo;
        }
        $data['sous_page'] = 'pages/form';
        $data['page'] = 'enclos/index';
        Flight::render('template', $data);
    }

    public function list()
    {
        $enclosModel = new EnclosModel(Flight::db());
        try {
            $enclos = $enclosModel->findAll();
            $data = ['page' => 'enclos/index', 'enclos' => $enclos, 'sous_page' => 'pages/list'];
            Flight::render('template', $data);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
