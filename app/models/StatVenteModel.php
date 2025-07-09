<?php
namespace app\models;
use Flight;

class StatVenteModel
{
     private $db;

    public function __construct() {
        $this->db = Flight::db();
    }
    public function getStatsVentes($annee) {
        $db = Flight::db();
        // Total ventes par mois
        $sqlMois = "SELECT EXTRACT(MONTH FROM date_commande) AS mois, SUM(quantite) AS total_ventes
                    FROM bao_commande
                    WHERE EXTRACT(YEAR FROM date_commande) = :annee
                    GROUP BY mois
                    ORDER BY mois ASC";
        $stmt = $this->db->prepare($sqlMois);
        $stmt->execute(['annee' => $annee]);
        $ventesMois = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Top 5 clients
        $sqlClients = "SELECT c.nom_client, SUM(bc.quantite) AS total_ventes
                       FROM bao_commande bc
                       JOIN bao_client c ON c.id_client = bc.id_client
                       WHERE EXTRACT(YEAR FROM bc.date_commande) = :annee
                       GROUP BY c.nom_client
                       ORDER BY total_ventes DESC
                       LIMIT 5";
        $stmt2 = $this->db->prepare($sqlClients);
        $stmt2->execute(['annee' => $annee]);
        $topClients = $stmt2->fetchAll(\PDO::FETCH_ASSOC);

        // Quantité totale vendue
        $sqlTotal = "SELECT SUM(quantite) AS quantite_totale FROM bao_commande WHERE EXTRACT(YEAR FROM date_commande) = :annee";
        $stmt3 = $this->db->prepare($sqlTotal);
        $stmt3->execute(['annee' => $annee]);
        $quantiteTotale = $stmt3->fetchColumn();

        // Nombre total de commandes
        $sqlNbCmd = "SELECT COUNT(*) FROM bao_commande WHERE EXTRACT(YEAR FROM date_commande) = :annee";
        $stmt4 = $this->db->prepare($sqlNbCmd);
        $stmt4->execute(['annee' => $annee]);
        $nbCommandes = $stmt4->fetchColumn();

        // Statut livraison (répartition)
        $sqlStatut = "SELECT statut_livraison, COUNT(*) AS nb FROM bao_commande WHERE EXTRACT(YEAR FROM date_commande) = :annee GROUP BY statut_livraison";
        $stmt5 = $this->db->prepare($sqlStatut);
        $stmt5->execute(['annee' => $annee]);
        $statuts = $stmt5->fetchAll(\PDO::FETCH_ASSOC);

        // Répartition par adresse de livraison
        $sqlAdresse = "SELECT adresse_livraison, COUNT(*) AS nb FROM bao_commande WHERE EXTRACT(YEAR FROM date_commande) = :annee GROUP BY adresse_livraison ORDER BY nb DESC LIMIT 5";
        $stmt6 = $this->db->prepare($sqlAdresse);
        $stmt6->execute(['annee' => $annee]);
        $adresses = $stmt6->fetchAll(\PDO::FETCH_ASSOC);

        // Répartition par enclos
        $sqlEnclos = "SELECT id_enclos_portee, COUNT(*) AS nb FROM bao_commande WHERE EXTRACT(YEAR FROM date_commande) = :annee GROUP BY id_enclos_portee ORDER BY nb DESC LIMIT 5";
        $stmt7 = $this->db->prepare($sqlEnclos);
        $stmt7->execute(['annee' => $annee]);
        $enclos = $stmt7->fetchAll(\PDO::FETCH_ASSOC);

        // Répartition par mois de livraison (pour retards, etc.)
        $sqlLivraison = "SELECT EXTRACT(MONTH FROM date_livraison) AS mois, COUNT(*) AS nb FROM bao_commande WHERE EXTRACT(YEAR FROM date_commande) = :annee GROUP BY mois ORDER BY mois ASC";
        $stmt8 = $this->db->prepare($sqlLivraison);
        $stmt8->execute(['annee' => $annee]);
        $livraisons = $stmt8->fetchAll(\PDO::FETCH_ASSOC);

        return [
            'ventesMois' => $ventesMois,
            'topClients' => $topClients,
            'quantiteTotale' => $quantiteTotale,
            'nbCommandes' => $nbCommandes,
            'statuts' => $statuts,
            'adresses' => $adresses,
            'enclos' => $enclos,
            'livraisons' => $livraisons
        ];
    }
}