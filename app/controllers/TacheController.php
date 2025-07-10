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
        SessionMiddleware::startSession();
        $taches = $this->model->all();
        $content = Flight::view()->fetch('tache/taches_liste', [
            'taches' => $taches
        ]);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    // Formulaire de création/modification de tâche
    public function form($id = null) {
        SessionMiddleware::startSession();
        $tache = null;
        if ($id) {
            $tache = $this->model->find($id);
        }
        $postes = $this->model->getPostes();
        $content = Flight::view()->fetch('tache/tache_form', [
            'tache' => $tache,
             'postes' => $postes
        ]);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    // Update assignForm to include precision
    public function assignForm() {
        SessionMiddleware::startSession();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['continue'])) {
            $id_employe = $_POST['id_employe'];
            $employe = $this->model->getEmploye($id_employe);
            $taches = $this->model->getByPoste($employe['id_employe_poste']);
            $step = 2;
            
            $content = Flight::view()->fetch('tache/tache_assign', [
                'step' => $step,
                'id_employe' => $id_employe,
                'employe_nom' => $employe['nom_employe'] . ' ' . $employe['prenom_employe'],
                'taches' => $taches
            ]);
            Flight::render('template-quixlab', ['content' => $content]);
        } else {
            $employes = $this->model->getEmployesActifs();
            $step = 1;
            $content = Flight::view()->fetch('tache/tache_assign', [
                'step' => $step,
                'employes' => $employes
            ]);
            Flight::render('template-quixlab', ['content' => $content]);
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
            Flight::redirect(BASE_URL.'/tache');
        }
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
            Flight::redirect(BASE_URL.'/tache');
        }
    }

    // Supprimer une tâche
    public function delete($id) {
        $this->model->delete($id);
        Flight::redirect('/taches');
    }

    public function getTaches() {
        $taches = $this->model->all();
        Flight::json($taches);
    }

    //?======== Emp side
    public function employeeLanding() {
        SessionMiddleware::startSession();
        
        if ($_SESSION['user_role_id'] != 2) {
            Flight::redirect('/', ['error' => 'Accès interdit. Vous devez être connecté en tant que employé.']);
            return;
        }

        $id_employe = $_SESSION['user_id'];
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        $tasks = TacheModel::getTachesEmploye($id_employe);
        
        $selectedDate = date('Y-m-d');
        
        Flight::render('tache/employee_landing', [
            'tasks' => $tasks,
            'selectedDate' => $selectedDate,
            'flash' => $flash,
            'id_employe' => $id_employe
        ]);
    }

    public function peserPorcs() {
        // Afficher la page pour enregistrer une nouvelle pesée
        SessionMiddleware::startSession();
        $content = Flight::view()->fetch('tache/tache_peser');
        Flight::render('template-quixlab', ['content' => $content]);
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
            Flight::redirect(BASE_URL.'/taches/employe/' . $id_employe);
        } else {
            Flight::redirect(BASE_URL.'/');
        }
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
