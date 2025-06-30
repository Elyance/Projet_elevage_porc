<?php
namespace app\controllers;

use app\models\EmployerModel;
use Flight;
use app\models\VenteModel;
use app\models\MessageModel;
use PDO;
class EmployerController {

    
    public static function show_insert_emp(){
        
        $model = new EmployerModel(Flight::db());
        $postes = $model->getpostes();
        $data = [
            'postes' => $postes
        ];
       
        Flight::render('insert_employer', $data);
    }
    public static function insert_emp(){
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
      
}
    }


public static function showd(){
    $data = [
       
        'categories' => 'a'
    ];

    Flight::render('dA', $data);
}



}
?>