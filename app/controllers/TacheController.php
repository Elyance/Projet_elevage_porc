<?php
namespace app\controllers;

use app\models\TacheModel;
use DateTime;
use Flight;

class TacheController {
    public function index() {
        // Page principale pour la gestion des tâches
        Flight::render("tache/index", ["message" => "Placeholder for gestion taches"]);
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
}

