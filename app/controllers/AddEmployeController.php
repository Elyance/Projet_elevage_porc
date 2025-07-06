<?php
namespace app\controllers;

use app\models\TacheModel;
use app\models\EmployerModel;
use Flight;

class AddEmployeController
{
    public function index()
    {
        $model = new EmployerModel(Flight::db());
        $post = $model->getpostes();
        $data = [
            'postes' => $post
        ];
       
        Flight::render('add_employe/index', $data);
    }
        public static function add(){
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $poste = $_POST['poste'];
        $adresse = $_POST['adresse'];
        $telephone = $_POST['telephone'];
        $date_recrutement = $_POST['date_recrutement'];
        $statut = $_POST['statut'];
        $model = new EmployerModel(Flight::db());
        $postes = $model->insert_emp($nom,$prenom,$poste,$adresse,$telephone,$date_recrutement,$statut);
        $post = $model->getpostes();
        $data = [
            'postes' => $post
        ];
       
        Flight::render('add_employe/index', $data);
      
}
    }
}