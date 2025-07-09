<?php
namespace app\controllers;

use app\models\CongeModel;
use app\models\PresenceModel;
use app\models\EmployeModel;
use Flight;
use SessionMiddleware;

class CongeController
{
    public function addForm()
    {
        $employes = EmployeModel::getAll();
        $selected_employe = Flight::request()->query->id_employe ? (int)Flight::request()->query->id_employe : null;

        Flight::render("conge/add", [
            "employes" => $employes,
            "selected_employe" => $selected_employe
        ]);
    }

    public function add()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id_employe = $_POST["id_employe"];
            $date_debut = $_POST["date_debut"];
            $date_fin = $_POST["date_fin"];
            $motif = $_POST["motif"];

            // Validate dates
            if (strtotime($date_fin) < strtotime($date_debut)) {
                Flight::redirect("/conge/add?error=invalid_dates" . ($id_employe ? "&id_employe=$id_employe" : ""));
                return;
            }

            // Create leave record
            CongeModel::create($id_employe, $date_debut, $date_fin, $motif);

            // Insert daily presence records as "absent"
            PresenceModel::insertDailyPresences($id_employe, $date_debut, $date_fin);

            Flight::redirect("/conge/add?success=leave_added" . ($id_employe ? "&id_employe=$id_employe" : ""));
        }
    }
}