<?php
namespace app\controllers;

use app\models\EmployeModel;
use app\models\SalaireModel;
use app\models\PresenceModel;
use app\models\EmployePosteModel;
use Flight;

class SalaireController
{
    public function index()
    {
        $month = $_GET["mois"] ?? date("m");
        $year = $_GET["annee"] ?? date("Y");
        $employes = EmployeModel::getAll();

        Flight::render("salaire/index", [
            "employes" => $employes,
            "month" => $month,
            "year" => $year,
            "months" => range(1, 12),
            "years" => range(date("Y") - 5, date("Y"))
        ]);
    }

    public function payer($id)
    {
        $month = $_GET["mois"] ?? date("m");
        $year = $_GET["annee"] ?? date("Y");
        $employe = EmployeModel::getAll(["id_employe" => $id])[0];
        $poste = EmployePosteModel::getAll(["id_employe_poste" => $employe->id_employe_poste])[0];
        $salaire_brut = $poste->salaire_base;

        // Calculate days present using custom method
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $start_date = "$year-$month-01";
        $end_date = "$year-$month-$days_in_month";
        $presences = PresenceModel::getDaysPresentByEmployeeAndMonth($id, $start_date, $end_date);
        $nb_jours_present = count(array_filter($presences, fn($p) => $p->statut === "present"));
        $taux = $nb_jours_present / $days_in_month;
        $salaire_final = $salaire_brut * $taux;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $montant = floatval($_POST["salaire_final"]);
            $date_salaire = "$year-$month-01"; // Use first day of the month
            SalaireModel::create((int)$id, $date_salaire, $montant, "payé");
            Flight::redirect("/salaire?mois=$month&annee=$year");
        }

        Flight::render("salaire/payer", [
            "employe" => $employe,
            "salaire_brut" => $salaire_brut,
            "nb_jours_present" => $nb_jours_present,
            "taux" => $taux,
            "salaire_final" => $salaire_final,
            "month" => $month,
            "year" => $year
        ]);
    }

    public function historiquePaie()
    {
        $employe_id = $_GET["employe"] ?? null;
        $year = $_GET["annee"] ?? date("Y");
        $conditions = $employe_id ? ["id_employe" => $employe_id] : [];
        $salaires = SalaireModel::getAll($conditions);
        $employes = EmployeModel::getAll();

        $data = [];
        foreach ($salaires as $salaire) {
            $month = date("m", strtotime($salaire->date_salaire));
            $emp = array_filter($employes, fn($e) => $e->id_employe == $salaire->id_employe)[0];
            $presences = PresenceModel::getDaysPresentByEmployeeAndMonth($salaire->id_employe, "$year-$month-01", "$year-$month-" . cal_days_in_month(CAL_GREGORIAN, $month, $year));
            $nb_jours_present = count(array_filter($presences, fn($p) => $p->statut === "present"));
            $taux = $nb_jours_present / cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $data[] = [
                "mois" => $month,
                "nb_jours_present" => $nb_jours_present,
                "taux" => $taux,
                "salaire_final" => $salaire->montant
            ];
        }

        Flight::render("salaire/historique_paie", [
            "employes" => $employes,
            "selected_employe" => $employe_id,
            "year" => $year,
            "years" => range(date("Y") - 5, date("Y")),
            "data" => $data
        ]);
    }
}