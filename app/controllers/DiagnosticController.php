<?php

namespace app\controllers;

use app\models\Diagnostic;
use app\models\Enclos;
use app\models\Maladie;
use app\controllers\EnclosController;
use Exception;
use Flight;
use DateTime;

class DiagnosticController
{
    public function soin()
    {
        Flight::render('maladie/soin');
    }
    public function home()
    {
        $diagnostic = new Diagnostic(Flight::db());
        Flight::render('maladie/listDiagnostic', ['diagnostics' => $diagnostic->findAll()]);
    }

    public function formAddDiagnostic() {
        $maladie = new Maladie(Flight::db());
        $enclos_portee = new Enclos(Flight::db()); // Assuming Enclos model handles bao_enclos_portee
        $data = [
            'maladies' => $maladie->findAll(),
            'enclos_portee' => $enclos_portee->findAllEnclosPortee() // Adjust method name based on Enclos model
        ];
        Flight::render('maladie/createDiagnostic', $data);
    }

    public function addDiagnostic() {
        $data = Flight::request()->data;
        $diagnostic = new Diagnostic(Flight::db());
        try {
            $diagnostic->ajouterDiagnostic($data);
            Flight::redirect('/diagnostic/add?success=Evenement cree');
        } catch (Exception $th) {
            Flight::redirect('/diagnostic/add?error=Erreur lors de la creation de l\'evenement');
        }
    }

    public function listDiagnostic()
    {
        $diagnostic = new Diagnostic(Flight::db());
        $diagnostics = $diagnostic->findByStatus('signale'); // Changed to use findByStatus
        Flight::render('maladie/listDiagnostic', ['diagnostics' => $diagnostics]);
    }

    public function listSignale()
    {
        $diagnostic = new Diagnostic(Flight::db());
        $diagnostics = $diagnostic->findByStatus('signale');
        Flight::render('maladie/listSignale', ['diagnostics' => $diagnostics]);
    }

    public function formMoveToQuarantine($id_diagnostic)
    {
        $diagnostic = new Diagnostic(Flight::db());
        $moveData = $diagnostic->moveToQuarantine($id_diagnostic);
        $conn = Flight::db();
        $stmt = $conn->query("
            SELECT id_enclos, nom_type, surface
            FROM bao_enclos e
            JOIN bao_type_porc t ON e.enclos_type = t.id_type_porc
            WHERE t.nom_type = 'Quarantaine'
        ");
        $quarantineEnclos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $data = [
            'id_diagnostic' => $id_diagnostic,
            'moveData' => $moveData,
            'quarantineEnclos' => $quarantineEnclos,
            'page' => 'maladie/moveToQuarantine'
        ];
        Flight::render('template', $data);
    }

    public function moveToQuarantine($id_diagnostic)
    {
        if (Flight::request()->method == 'POST') {
            $diagnostic = new Diagnostic(Flight::db());
            $moveData = $diagnostic->moveToQuarantine($id_diagnostic);
            $id_enclos_destination = Flight::request()->data->id_enclos_destination;

            if ($id_enclos_destination === null) {
                Flight::redirect('/maladie/signale?error=Enclos de quarantaine non sélectionné');
                return;
            }

            // Use EnclosController's movePorteeManually logic
            $enclosController = new EnclosController();
            try {
                $enclosController->movePorteeManually(
                    $moveData['id_enclos_portee_original'],
                    $id_enclos_destination,
                    $moveData['nombre_males_infectes'],
                    $moveData['nombre_femelles_infectes']
                );
            } catch (Exception $e) {
                echo $e;
                // Flight::redirect('/maladie/signale?error=Erreur lors du déplacement: ' . $e->getMessage());
                // return;
            }

            // Update diagnostic status and enclosure
            $diagnostic->updateStatusAndEnclos($id_diagnostic, 'en quarantaine', $id_enclos_destination, $moveData['id_enclos_portee_original']);
            // Flight::redirect('/maladie/signale?success=Mis en quarantaine');
        } else {
            // Flight::redirect('/diagnostic/moveToQuarantine/' . $id_diagnostic);
        }
    }

    public function listQuarantine()
    {
        $diagnostic = new Diagnostic(Flight::db());
        $diagnostics = $diagnostic->findByStatus('en quarantaine');
        Flight::render('maladie/listQuarantine', ['diagnostics' => $diagnostics]);
    }

    public function startTreatment($id_diagnostic)
    {
        $diagnostic = new Diagnostic(Flight::db());
        try {
            $diagnostic->startTreatment($id_diagnostic);
            Flight::redirect('/maladie/quarantine?success=Traitement commencé');
        } catch (Exception $e) {
            Flight::redirect('/maladie/quarantine?error=Erreur lors du début du traitement: ' . $e->getMessage());
        }
    }

    public function listTreatment()
    {
        $diagnostic = new Diagnostic(Flight::db());
        $diagnostics = $diagnostic->findByStatus('en traitement');
        Flight::render('maladie/listTreatment', ['diagnostics' => $diagnostics]);
    }

    public function markSuccess($id_diagnostic)
    {
        $diagnostic = new Diagnostic(Flight::db());
        try {
            $diagnostic->markSuccess($id_diagnostic);
            Flight::redirect('/maladie/treatment?success=Traitement réussi');
        } catch (Exception $e) {
            Flight::redirect('/maladie/treatment?error=Erreur lors de la marque de succès: ' . $e->getMessage());
        }
    }

    public function markFailure($id_diagnostic)
    {
        $diagnostic = new Diagnostic(Flight::db());
        try {
            $diagnostic->markFailure($id_diagnostic);
            Flight::redirect('/maladie/treatment?success=Traitement échoué');
        } catch (Exception $e) {
            Flight::redirect('/maladie/treatment?error=Erreur lors de la marque d\'échec: ' . $e->getMessage());
        }
    }

    public function recordDeath($id_diagnostic)
    {
        $data = Flight::request()->data;
        $nombre_deces = $data['nombre_deces'];
        $diagnostic = new Diagnostic(Flight::db());
        try {
            $diagnostic->recordDeath($id_diagnostic, $nombre_deces);
            Flight::redirect('/maladie/treatment?success=Décès enregistré');
        } catch (Exception $e) {
            Flight::redirect('/maladie/treatment?error=Erreur lors de l\'enregistrement du décès: ' . $e->getMessage());
        }
    }
}