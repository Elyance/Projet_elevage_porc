<?php
namespace app\models;

class SimulationBeneficeModel
{
    public function simulerElevage($params) {
        $simulation = [];
        $porcelets = [];
        $totalBenefice = 0;
        $nbTruies = $params['nbTruies'];
        $nbPorcs = $params['nbPorcs'];

        for ($mois = 1; $mois <= $params['nbMoisSimulation']; $mois++) {
            $moisData = [
                'mois' => $mois,
                'nbTruies' => $nbTruies,
                'nbPorcs' => $nbPorcs,
                'nbPorcelets' => 0,
                'nouveauxPorcelets' => 0,
                'porcsVendus' => 0,
                'porceletsDevenusPorc' => 0,
                'revenus' => 0,
                'couts' => 0,
                'beneficeMensuel' => 0,
                'beneficeCumule' => 0,
                'evenements' => []
            ];

            $moisData['couts'] = ($nbTruies * $params['prixAlimentTruie']) + ($nbPorcs * $params['prixAlimentPorc']);

            if ($mois % 12 === $params['moisNaissance'] || ($mois === $params['moisNaissance'] && $mois <= 12)) {
                $moisData['nouveauxPorcelets'] = $nbTruies * $params['porceletsParAn'];
                $porcelets[$mois] = $moisData['nouveauxPorcelets'];
                $moisData['evenements'][] = "Naissance de {$moisData['nouveauxPorcelets']} porcelets";
            }

            $porceletsTotal = 0;
            foreach ($porcelets as $moisNaissance => $nb) {
                $age = $mois - (int)$moisNaissance;
                if ($age >= 0 && $age < $params['moisMaturation']) {
                    $porceletsTotal += $nb;
                } elseif ($age === $params['moisMaturation']) {
                    $moisData['porceletsDevenusPorc'] += $nb;
                    if ($params['venteAutomatique']) {
                        $moisData['porcsVendus'] += $nb;
                        $moisData['revenus'] += $nb * $params['prixVentePorc'];
                        $moisData['evenements'][] = "$nb porcelets deviennent porcs et sont vendus";
                    } else {
                        $nbPorcs += $nb;
                        $moisData['evenements'][] = "$nb porcelets deviennent des porcs";
                    }
                    unset($porcelets[$moisNaissance]);
                }
            }

            $moisData['couts'] += $porceletsTotal * $params['prixAlimentPorcelet'];
            $moisData['nbPorcelets'] = $porceletsTotal;

            if ($params['venteAutomatique'] && $nbPorcs > 0) {
                $moisData['porcsVendus'] += $nbPorcs;
                $moisData['revenus'] += $nbPorcs * $params['prixVentePorc'];
                $moisData['evenements'][] = "$nbPorcs porcs en stock vendus";
                $nbPorcs = 0;
            }

            $moisData['nbPorcs'] = $nbPorcs;
            $moisData['beneficeMensuel'] = $moisData['revenus'] - $moisData['couts'];
            $totalBenefice += $moisData['beneficeMensuel'];
            $moisData['beneficeCumule'] = $totalBenefice;

            $simulation[] = $moisData;
        }
        return $simulation;
    }
}