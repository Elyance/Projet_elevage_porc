<?php
namespace app\controllers;

use app\models\CycleModel;
use app\models\TruieModel;
use Flight;

class CycleController {
    public function index()
    {
        $cycleModel = new CycleModel(Flight::db());
        $cycles = $cycleModel->findAll();

        Flight::render('cycle/index', ['cycles' => $cycles]);
    }

    public function add()
    {
        $truieModel = new TruieModel(Flight::db());
        $truies = $truieModel->findAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $truie_id = $_POST['truie_id'];
            $date_debut_cycle = $_POST['date_debut_cycle'];
            $date_fin_cycle = $_POST['date_fin_cycle'];
            $nombre_portee = $_POST['nombre_portee'] ?? 0;

            $cycleModel = new CycleModel(Flight::db());
            $cycleModel->create($truie_id, $date_debut_cycle, $date_fin_cycle, $nombre_portee);

            Flight::redirect('/cycle');
        }

        Flight::render('cycle/add', ['truies' => $truies]);
    }

    public function details($id)
    {
        $cycleModel = new CycleModel(Flight::db());
        $currentCycle = $cycleModel->findById($id);

        if ($currentCycle['etat'] !== 'en cours') {
            // If the requested cycle is not 'en cours', redirect to the current 'en cours' cycle for this truie
            $stmt = $this->db->prepare('SELECT id_cycle_reproduction FROM bao_cycle_reproduction WHERE id_truie = :id_truie AND etat = \'en cours\'');
            $stmt->execute([':id_truie' => $currentCycle['id_truie']]);
            $currentId = $stmt->fetchColumn();
            if ($currentId) {
                Flight::redirect('/cycle/details/' . $currentId);
                return;
            }
        }

        $truieId = $currentCycle['id_truie'];

        // Get the last terminated cycle as the precedent
        $stmt = $this->db->prepare('SELECT * FROM bao_cycle_reproduction WHERE id_truie = :id_truie AND etat = \'terminée\' ORDER BY date_fin_cycle DESC LIMIT 1');
        $stmt->execute([':id_truie' => $truieId]);
        $precedentCycle = $stmt->fetch(PDO::FETCH_ASSOC);

        // Prevision remains unchanged, using all previous cycles
        $stmt = $this->db->prepare('SELECT AVG(DATEDIFF(date_fin_cycle, date_debut_cycle)) as avg_days, AVG(nombre_portee) as avg_portee FROM bao_cycle_reproduction WHERE id_truie = :id_truie AND nombre_portee IS NOT NULL AND id_cycle_reproduction != :current_id');
        $stmt->execute([':id_truie' => $truieId, ':current_id' => $id]);
        $prevision = $stmt->fetch(PDO::FETCH_ASSOC);
        $avgDays = $prevision['avg_days'] ?: 115;
        $avgPortee = $prevision['avg_portee'] ?: 0;

        Flight::render('cycle/details', [
            'currentCycle' => $currentCycle,
            'precedentCycle' => $precedentCycle,
            'prevision' => ['days' => $avgDays, 'portee' => $avgPortee]
        ]);
    }
}