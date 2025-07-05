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
        $post = $model->getpostes();
        $data = [
            'postes' => $post
        ];
       
        Flight::render('insert_employer', $data);
      
}
    }


public static function showAcceuil(){
    $model = new EmployerModel(Flight::db());
    $emp = $model->getemp();
    $data = [
       
        'employes' => $emp
    ];

    Flight::render('Acceuil_emp', $data);
}
public static function update(){
    $model = new EmployerModel(Flight::db());
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['changer_statut'])) {
        $id_emp = $_POST['id_employe'];
        $nouveau_statut = $_POST['nouveau_statut'];

        if (in_array($nouveau_statut, ['actif', 'retraiter', 'congedier'])) {
            if ($nouveau_statut === 'actif') {
                $model->update($nouveau_statut, $id_emp);
            } 
            else {
                $model->update2($nouveau_statut, $id_emp);
            }
        }
    }
    
    $emp = $model->getemp();
    $data = [
       
        'employes' => $emp
    ];

    Flight::render('Acceuil_emp', $data);
}
    public function calendrier() {
        $data = [
            'postes' => 'a'
        ];
       
        Flight::render('calendrier', $data);
       
    }

    public function getEmployes() {
        $model = new EmployerModel(Flight::db());
        header('Content-Type: application/json');
        echo json_encode($model->getActifs());
    }

    public function getDates() {
        $model = new EmployerModel(Flight::db());
        header('Content-Type: application/json');
        echo json_encode($model->getDatesTraitees());
    }

    public function enregistrer() {
        $model = new EmployerModel(Flight::db());
        $date = $_POST['date_presence'];
        $absents = isset($_POST['absents']) ? $_POST['absents'] : [];

        if ($model->dejaTraite($date)) {
            echo "⚠️ Date déjà enregistrée.";
        } else {
            $model->enregistrer($date, $absents);
            echo "✅ Enregistrement fait pour $date.";
        }
    }



}
?>