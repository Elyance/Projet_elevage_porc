<?php

namespace app\controllers;

use app\models\Truie;
use app\models\Tache;
use Flight;
require_once __DIR__ . '/../models/Tache.php';
// app/controllers/TacheController.php
class TacheController {

    protected $model;

    public function __construct() {
        $this->model = new Tache();
    }

    // Affiche la liste des tâches (admin)
    public function index() {
        $taches = $this->model->all();
        Flight::render('taches_liste', ['taches' => $taches]);
    }

    // Formulaire de création/modification de tâche
    public function form($id = null) {
        $tache = null;
        if ($id) {
            $tache = $this->model->find($id);
        }
        $postes = $this->model->getPostes();
        Flight::render('tache_form', ['tache' => $tache, 'postes' => $postes]);
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

    // Formulaire d'assignation d'une tâche à un employé
    public function assignForm() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['continue'])) {
            $id_employe = $_POST['id_employe'];
            $employe = $this->model->getEmploye($id_employe);
            $taches = $this->model->getByPoste($employe['id_employe_poste']);
            $step = 2;
            Flight::render('tache_assign', [
                'step' => $step,
                'id_employe' => $id_employe,
                'employe_nom' => $employe['nom_employe'].' '.$employe['prenom_employe'],
                'taches' => $taches
            ]);
        } else {
            $employes = $this->model->getEmployesActifs();
            $step = 1;
            Flight::render('tache_assign', [
                'step' => $step,
                'employes' => $employes
            ]);
        }
    }

    // Enregistrer l'assignation
    public function assignSave() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->assignTache([
                'id_employe' => $_POST['id_employe'],
                'id_tache' => $_POST['id_tache'],
                'date_echeance' => $_POST['date_echeance']
            ]);
            Flight::redirect('/taches');
        }
    }

    // Liste des tâches assignées à un employé (côté employé)
    public function employeTaches($id_employe) {
        $employe = $this->model->getEmploye($id_employe);
        $taches = $this->model->getTachesEmploye($id_employe);
        $employe_nom = $employe['nom_employe'] . ' ' . $employe['prenom_employe'];
        Flight::render('taches_employe', [
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
}
