<?php
namespace app\controllers;

use app\models\PresenceModel;
use app\models\EmployeModel;
use Flight;
use SessionMiddleware;

class PresenceController
{
    public function index()
    {
        $month = $_GET["mois"] ?? date("m");
        $year = $_GET["annee"] ?? date("Y");
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $days = range(1, $days_in_month);

        Flight::render("presence/index", [
            "month" => $month,
            "year" => $year,
            "days" => $days,
            "months" => range(1, 12),
            "years" => range(date("Y") - 5, date("Y"))
        ]);
    }

    public function detailJour($date)
    {
        $presences = PresenceModel::getAll(["date_presence" => $date]);
        $employes = EmployeModel::getAll();
        $present = array_filter($presences, fn($p) => $p->statut === "present");
        
        $present_employes = array_map(function ($p) use ($employes) {
            $matching_employes = array_filter($employes, fn($e) => $e->id_employe == $p->id_employe);
            return !empty($matching_employes) ? array_values($matching_employes)[0] : null;
        }, $present);

        Flight::render("presence/detail_jour", [
            "date" => $date,
            "present_employes" => $present_employes,
            "conge_payes" => []
        ]);
    }

    public function addPresence()
    {
        $date = $_GET["date"] ?? date("Y-m-d");
        $employes = EmployeModel::getAll();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            foreach ($employes as $employe) {
                $statut = isset($_POST["presence_" . $employe->id_employe]) ? "present" : "absent";
                $existing = PresenceModel::getAll(["id_employe" => $employe->id_employe, "date_presence" => $date]);
                if (empty($existing)) {
                    PresenceModel::create($employe->id_employe, $date, $statut);
                } else {
                    PresenceModel::updateStatut($existing[0]->id_presence, $statut);
                }
            }
            Flight::redirect("/presence/detail_jour/$date");
        }

        Flight::render("presence/add_presence", [
            "employes" => $employes,
            "date" => $date
        ]);
    }
}