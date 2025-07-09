<?php
namespace app\controllers;

use app\models\TacheModel;
use app\models\Tache;
use DateTime;
use Flight;
use SessionMiddleware;


require_once __DIR__ . '/../models/Tache.php';

class TacheController {
    protected $model;
    
    public function __construct() {
        $this->model = new Tache();
    }

    // Affiche la liste des tâches (admin)
    public function index() {
        $taches = $this->model->all();
        Flight::render('tache/taches_liste', ['taches' => $taches]);
    }

    public function peserPorcs() {
        // Afficher la page pour enregistrer une nouvelle pesée
        Flight::render('tache/tache_peser');
    }

    public function submitPesee() {
        // Traitement de la soumission du formulaire de pesée
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $enclos_id = filter_input(INPUT_POST, 'enclos_id', FILTER_VALIDATE_INT);
            $weight = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT);
            $date = filter_input(INPUT_POST, 'date', FILTER_DEFAULT);

            // Validation de la date
            if ($date && DateTime::createFromFormat('Y-m-d', $date) !== false) {
                $date = DateTime::createFromFormat('Y-m-d', $date)->format('Y-m-d');
            } else {
                Flight::redirect('/tache_peser?error=Date invalide (format attendu : YYYY-MM-DD)');
                exit();
            }

            if ($enclos_id && $weight !== false && $date) {
                if ($weight >= 1 && $weight <= 200) {
                    if (TacheModel::create($enclos_id, $weight, $date)) {
                        Flight::redirect('/tache_peser?message=Pesée enregistrée avec succès');
                    } else {
                        Flight::redirect('/tache_peser?error=Erreur lors de l\'enregistrement');
                    }
                } else {
                    Flight::redirect('/tache_peser?error=Le poids doit être entre 1 et 200 kg');
                }
            } else {
                Flight::redirect('/tache_peser?error=Données invalides');
            }
        } else {
            Flight::halt(405, "Méthode non autorisée");
        }
    }

    public function historiquePesee() {
        // Afficher l'historique des pesées
        $pesees = TacheModel::getAll(); // Récupère toutes les pesées
        Flight::render('tache/historique_pesee', ['pesees' => $pesees]);
    }

    // Formulaire de création/modification de tâche
    public function form($id = null) {
        $tache = null;
        if ($id) {
            $tache = $this->model->find($id);
        }
        $postes = $this->model->getPostes();
        Flight::render('tache/tache_form', ['tache' => $tache, 'postes' => $postes]);
    }

    // Enregistrer une tâche (création ou modification)
    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id_employe_poste' => $_POST['id_employe_poste'],
                'nom_tache' => $_POST['nom_tache'],
                'description' => $_POST['description']
            ];
            if (!empty($_POST['id_tache'])) {
                $this->model->update($_POST['id_tache'], $data);
            } else {
                $this->model->create($data);
            }
            Flight::redirect('/taches');
        }
    }

    // Supprimer une tâche
    public function delete($id) {
        $this->model->delete($id);
        Flight::redirect('/taches');
    }

    public function employeeLanding() {

        $id_employe = $_SESSION['user_id'];

        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        $currentMonth = date('m');
        $currentYear = date('Y');
        $tasks = TacheModel::getTachesEmploye($id_employe);
        
        $calendar = [];
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
        $firstDay = new DateTime("$currentYear-$currentMonth-01");
        $dayOfWeek = $firstDay->format('w');
        
        for ($i = 0; $i < ($dayOfWeek + $daysInMonth); $i++) {
            $day = $i - $dayOfWeek + 1;
            $dateKey = $currentYear . '-' . str_pad($currentMonth, 2, '0', STR_PAD_LEFT) . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
            $calendar[$i] = [
                'day' => $day > 0 && $day <= $daysInMonth ? $day : '',
                'tasks' => array_filter($tasks, fn($t) => $t['date_echeance'] === $dateKey) ?: []
            ];
        }
        $tasks = TacheModel::getTachesEmploye($id_employe);
        
        Flight::render('tache/employee_landing', [
            'calendar' => $calendar,
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear,
            'id_employe' => $id_employe,
            'flash' => $flash,
            'daysInMonth' => $daysInMonth,
            'dayOfWeek' => $dayOfWeek,
            'tasks' => $tasks
        ]);
    }

    // Update assignForm to include precision
    public function assignForm() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['continue'])) {
            $id_employe = $_POST['id_employe'];
            $employe = $this->model->getEmploye($id_employe);
            $taches = $this->model->getByPoste($employe['id_employe_poste']);
            $step = 2;
            Flight::render('tache/tache_assign', [
                'step' => $step,
                'id_employe' => $id_employe,
                'employe_nom' => $employe['nom_employe'] . ' ' . $employe['prenom_employe'],
                'taches' => $taches
            ]);
        } else {
            $employes = $this->model->getEmployesActifs();
            $step = 1;
            Flight::render('tache/tache_assign', [
                'step' => $step,
                'employes' => $employes
            ]);
        }
    }

    // Update assignSave to include precision
    public function assignSave() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id_employe' => $_POST['id_employe'],
                'id_tache' => $_POST['id_tache'],
                'date_attribution' => $_POST['date_attribution'],
                'date_echeance' => $_POST['date_echeance'],
                'statut' => $_POST['statut'],
                'precision' => $_POST['precision'] ?? ''
            ];
            TacheModel::assignTache($data);
            Flight::redirect('/taches');
        }
    }

    // Liste des tâches assignées à un employé (côté employé)
    public function employeTaches($id_employe) {
        $employe = $this->model->getEmploye($id_employe);
        $taches = $this->model->getTachesEmploye($id_employe);
        $employe_nom = $employe['nom_employe'] . ' ' . $employe['prenom_employe'];
        Flight::render('tache/taches_employe', [
            'taches' => $taches,
            'employe_nom' => $employe_nom,
            'id_employe' => $id_employe
        ]);
    }

    // Marquer des tâches comme accomplies (employé)
    public function done() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['taches_done'])) {
            $this->model->setTachesDone($_POST['taches_done']);
        }
        $id_employe = $_POST['id_employe'] ?? null;
        if ($id_employe) {
            Flight::redirect('/taches/employe/' . $id_employe);
        } else {
            Flight::redirect('/');
        }
    }

    public function getTaches() {
        $taches = $this->model->all();
        Flight::json($taches);
    }

    public function getTacheById($id,$date) {
        $tache = $this->model->setTachesDone2($id,$date);
        if ($tache) {
            Flight::json($tache);
        } else {
            Flight::halt(404, "Tâche fait sauvegardee");
        }
    }
}
