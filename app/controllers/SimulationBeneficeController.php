<?php
namespace app\controllers;
use SessionMiddleware;

use app\models\SimulationBeneficeModel;
use app\models\StatAlimentModel;
use Flight;

class SimulationBeneficeController
{
    public static function showForm() {
        Flight::render('simulation/simulation_benefice_form');
    }

    public static function simulate() {
        // Simulation bénéfice
        $params = [
            'nbTruies' => (int)$_POST['nbTruies'],
            'nbPorcs' => (int)$_POST['nbPorcs'],
            'nbPorcelets' => (int)$_POST['nbPorcelets'],
            'porceletsParAn' => (int)$_POST['porceletsParAn'],
            'moisNaissance' => (int)$_POST['moisNaissance'],
            'moisMaturation' => (int)$_POST['moisMaturation'],
            'venteAutomatique' => isset($_POST['venteAutomatique']) && $_POST['venteAutomatique'] === 'true',
            'prixAlimentTruie' => (int)$_POST['prixAlimentTruie'],
            'prixAlimentPorc' => (int)$_POST['prixAlimentPorc'],
            'prixAlimentPorcelet' => (int)$_POST['prixAlimentPorcelet'],
            'prixVentePorc' => (int)$_POST['prixVentePorc'],
            'nbMoisSimulation' => (int)$_POST['nbMoisSimulation'],
        ];
        $model = new SimulationBeneficeModel();
        $result = $model->simulerElevage($params);

        // Statistiques aliment (si formulaire soumis)
        $aliments_stats = null;
        $annee_aliment = null;
        if (isset($_POST['annee_aliment'])) {
            $annee_aliment = (int)$_POST['annee_aliment'];
            $statModel = new StatAlimentModel();
            $aliments_stats = $statModel->getStatsAliments($annee_aliment);
        }

        Flight::render(
            'simulation/simulation_benefice_result',
            [
                'simulation' => $result,
                'params' => $params,
                'aliments_stats' => $aliments_stats,
                'annee_aliment' => $annee_aliment
            ]
        );
    }
}