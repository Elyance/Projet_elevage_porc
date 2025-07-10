<?php
namespace app\controllers;

use Flight;
use app\models\EmployerModel;
use SessionMiddleware;

class AddEmployeController
{
        public function index()
    {
        SessionMiddleware::startSession();
        $model = new EmployerModel(Flight::db());
        $post = $model->getpostes();
        
        $content = Flight::view()->fetch('add_employe/index', [
            'postes' => $post
        ]);
        Flight::render('template-quixlab', ['content' => $content]);
    }
        public static function add(){
        SessionMiddleware::startSession();
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
        $content = Flight::view()->fetch('add_employe/index', [
            'postes' => $post
        ]);
        Flight::render('template-quixlab', ['content' => $content]);
      
}
        }
}