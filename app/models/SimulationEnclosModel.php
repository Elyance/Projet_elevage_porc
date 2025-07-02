<?php

namespace app\models;
use Flight;

class SimulationEnclosModel
{

    private $db;

    public function __construct() {
        $this->db = Flight::db();
    }
    

    /**
     * Calcule l'espace nécessaire pour chaque catégorie et le total.
     */
    public function calculerEspace($porcelets, $croissance, $engraissement, $truies, $verrats = 0) {
        // Moyenne des surfaces recommandées
        $espace_porcelet = 0.25;      // m²
        $espace_croissance = 0.5;     // m²
        $espace_engraissement = 0.85; // m²
        $espace_truie = 2.75;         // m²
        $espace_verrat = 6;           // m²

        $total_porcelets = $porcelets * $espace_porcelet;
        $total_croissance = $croissance * $espace_croissance;
        $total_engraissement = $engraissement * $espace_engraissement;
        $total_truies = $truies * $espace_truie;
        $total_verrats = $verrats * $espace_verrat;

        $total = $total_porcelets + $total_croissance + $total_engraissement + $total_truies + $total_verrats;

        return [
            'porcelets' => $total_porcelets,
            'croissance' => $total_croissance,
            'engraissement' => $total_engraissement,
            'truies' => $total_truies,
            'verrats' => $total_verrats,
            'total' => $total
        ];
    }

    /**
     * Calcule la dimension de la ferme et le schéma des enclos nécessaires.
     */
    public function calculerDimensions($porcelets, $porcs, $truies, $verrats = 0) {
        // Surfaces moyennes officielles
        $espace_porcelet = 0.25;      // m² (moyenne 0.2–0.3)
        $espace_porc = 0.7;           // m² (moyenne croissance/engraissement 0.4–1)
        $espace_truie = 2.75;         // m² (moyenne 2–3.5)
        $espace_verrat = 6;           // m² (min 6)
        $largeur_couloir = 1;         // m

        // Calculs
        $total_porcelets = $porcelets * $espace_porcelet;
        $total_porcs = $porcs * $espace_porc;
        $total_truies = $truies * $espace_truie;
        $total_verrats = $verrats * $espace_verrat;

        // Nombre d’enclos (exemple : 10 animaux/enclos)
        $enclos_porcelets = ceil($porcelets / 10);
        $enclos_porcs = ceil($porcs / 10);
        $enclos_truies = ceil($truies / 5);
        $enclos_verrats = max(1, $verrats);

        // Surface totale
        $surface_enclos = $total_porcelets + $total_porcs + $total_truies + $total_verrats;
        // Ajout couloirs (10% de la surface totale)
        $surface_couloir = $surface_enclos * 0.1;
        $surface_totale = $surface_enclos + $surface_couloir;

        // Schéma simple
        $schema = [
            'enclos_porcelets' => $enclos_porcelets,
            'enclos_porcs' => $enclos_porcs,
            'enclos_truies' => $enclos_truies,
            'enclos_verrats' => $enclos_verrats,
            'surface_porcelets' => $total_porcelets,
            'surface_porcs' => $total_porcs,
            'surface_truies' => $total_truies,
            'surface_verrats' => $total_verrats,
            'surface_couloir' => $surface_couloir,
            'surface_totale' => $surface_totale,
            'largeur_couloir' => $largeur_couloir
        ];

        return $schema;
    }
}