<?php

namespace app\controllers;

use app\models\Diagnostic;
use app\models\Enclos;
use app\models\Maladie;
use app\controllers\EnclosController;
use Exception;
use Flight;
use DateTime;
use SessionMiddleware;
use Tracy\Bar;

class DiagnosticController
{
    public function soin()
    {
        SessionMiddleware::startSession();
        $content = Flight::view()->fetch('maladie/soin');
        Flight::render('template-quixlab', ['content' => $content]);
    }
    public function home()
    {
        SessionMiddleware::startSession();
        $diagnostic = new Diagnostic(Flight::db());
        $content = Flight::view()->fetch('maladie/listDiagnostic', [
            'diagnostics' => $diagnostic->findAll()
        ]);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function formAddDiagnostic() {
        SessionMiddleware::startSession();
        $maladie = new Maladie(Flight::db());
        $enclos_portee = new Enclos(Flight::db()); // Assuming Enclos model handles bao_enclos_portee
        $data = [
            'maladies' => $maladie->findAll(),
            'enclos_portee' => $enclos_portee->findAllEnclosPortee() // Adjust method name based on Enclos model
        ];
        $content = Flight::view()->fetch('maladie/createDiagnostic', $data);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function addDiagnostic() {
        SessionMiddleware::startSession();
        $data = Flight::request()->data;
        $diagnostic = new Diagnostic(Flight::db());
        try {
            $diagnostic->ajouterDiagnostic($data);
            Flight::redirect(BASE_URL.'/diagnostic/add?success=Evenement cree');
        } catch (Exception $th) {
            Flight::redirect(BASE_URL.'/diagnostic/add?error=Erreur lors de la creation de l\'evenement');
        }
    }

    public function listDiagnostic()
    {
        SessionMiddleware::startSession();
        $diagnostic = new Diagnostic(Flight::db());
        $diagnostics = $diagnostic->findByStatus('signale'); // Changed to use findByStatus
        $content = Flight::view()->fetch('maladie/listDiagnostic', ['diagnostics' => $diagnostics]);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function listSignale()
    {
        SessionMiddleware::startSession();
        $diagnostic = new Diagnostic(Flight::db());
        $diagnostics = $diagnostic->findByStatus('signale');
        $content = Flight::view()->fetch('maladie/listSignale', ['diagnostics' => $diagnostics]);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function formMoveToQuarantine($id_diagnostic)
    {
        SessionMiddleware::startSession();
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
        ];
        $content = Flight::view()->fetch('maladie/moveToQuarantine', $data);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function moveToQuarantine($id_diagnostic)
    {
        SessionMiddleware::startSession();
        if (Flight::request()->method == 'POST') {
            $diagnostic = new Diagnostic(Flight::db());
            $moveData = $diagnostic->moveToQuarantine($id_diagnostic);
            $id_enclos_destination = Flight::request()->data->id_enclos_destination;

            if ($id_enclos_destination === null) {
                Flight::redirect(BASE_URL.'/maladie/signale?error=Enclos de quarantaine non sélectionné');
                return;
            }

            $enclosController = new EnclosController();
            $conn = \Flight::db();
            // $conn->beginTransaction();

            try {
                $id_tena_izy = $enclosController->movePorteeManually(
                    $moveData['id_enclos_portee_original'],
                    $id_enclos_destination,
                    $moveData['nombre_males_infectes'],
                    $moveData['nombre_femelles_infectes']
                );
                $diagnostic->updateStatusAndEnclos($id_diagnostic, 'en quarantaine', $moveData['id_enclos_portee_original'], $id_tena_izy);
                // $conn->commit();
                Flight::redirect(BASE_URL.'/maladie/signale?success=Mis en quarantaine');
            } catch (Exception $e) {
                // $conn->rollBack();
                echo $e;
                Flight::redirect(BASE_URL.'/maladie/signale?error=Erreur lors du déplacement: ' . $e->getMessage());
            }
        } else {
            Flight::redirect(BASE_URL.'/diagnostic/moveToQuarantine/' . $id_diagnostic);
        }
    }

    public function listQuarantine()
    {
        SessionMiddleware::startSession();
        $diagnostic = new Diagnostic(Flight::db());
        $diagnostics = $diagnostic->findByStatus('en quarantaine');
        $content = Flight::view()->fetch('maladie/listQuarantine', ['diagnostics' => $diagnostics]);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function startTreatment($id_diagnostic)
    {
        SessionMiddleware::startSession();
        $diagnostic = new Diagnostic(Flight::db());
        try {
            $diagnostic->startTreatment($id_diagnostic);
            Flight::redirect(BASE_URL.'/maladie/quarantine?success=Traitement commencé');
        } catch (Exception $e) {
            Flight::redirect(BASE_URL.'/maladie/quarantine?error=Erreur lors du début du traitement: ' . $e->getMessage());
        }
    }

    public function listTreatment()
    {
        SessionMiddleware::startSession();
        $diagnostic = new Diagnostic(Flight::db());
        $diagnostics = $diagnostic->findByStatuses(['en traitement', 'echec']);
        $content = Flight::view()->fetch('maladie/listTreatment', ['diagnostics' => $diagnostics]);
        Flight::render('template-quixlab', ['content' => $content]);
    }

    public function markSuccess($id_diagnostic)
    {
        SessionMiddleware::startSession();
        $diagnostic = new Diagnostic(Flight::db());
        if (Flight::request()->method == 'POST') {
            $id_enclos_destination = Flight::request()->data->id_enclos_destination;
            try {
                $conn = Flight::db();
                // $conn->beginTransaction();
                $diagnostic->markSuccess($id_diagnostic, $id_enclos_destination);
                // $conn->commit();
                Flight::redirect(BASE_URL.'/maladie/treatment?success=Traitement réussi');
            } catch (Exception $e) {
                // $conn->rollBack();
                Flight::redirect(BASE_URL.'/maladie/treatment?error=Erreur lors de la marque de succès: ' . $e->getMessage());
            }
        } else {
            $diagnosticData = $diagnostic->findById($id_diagnostic);
            $enclosList = \app\models\EnclosModel::getAllTsyArray(); // Fetch all enclosures with type details
            $content = Flight::view()->fetch('maladie/selectEnclosForHealedPigs', [
                'diagnostic' => $diagnosticData,
                'enclosList' => $enclosList
            ]);
            Flight::render('template-quixlab', ['content' => $content]);
        }
    }

    public function markFailure($id_diagnostic)
    {
        SessionMiddleware::startSession();
        $diagnostic = new Diagnostic(Flight::db());
        try {
            $diagnostic->markFailure($id_diagnostic);
            Flight::redirect(BASE_URL.'/maladie/treatment?success=Traitement échoué');
        } catch (Exception $e) {
            Flight::redirect(BASE_URL.'/maladie/treatment?error=Erreur lors de la marque d\'échec: ' . $e->getMessage());
        }
    }

    public function recordDeath($id_diagnostic)
    {
        SessionMiddleware::startSession();
        $data = Flight::request()->data;
        $male_deces = (int)($data['male_deces'] ?? 0);
        $female_deces = (int)($data['female_deces'] ?? 0);
        $diagnostic = new Diagnostic(Flight::db());
        try {
            $diagnostic->recordDeath($id_diagnostic, $male_deces, $female_deces);
            Flight::redirect(BASE_URL.'/maladie/treatment?success=Décès enregistré');
        } catch (Exception $e) {
            Flight::redirect(BASE_URL.'/maladie/treatment?error=Erreur lors de l\'enregistrement du décès: ' . $e->getMessage());
        }
    }
}