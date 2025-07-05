<?php
namespace app\controllers;

use app\models\SimulationBeneficeModel;
use Flight;

class SimulationBeneficeController
{
    public static function showForm() {
        Flight::render('simulation_benefice_form');
    }

    public static function simulate() {
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
        Flight::render('simulation_benefice_result', ['simulation' => $result, 'params' => $params]);
    }
}