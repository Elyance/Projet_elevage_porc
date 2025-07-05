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
                    ORDER BY total_ventes DESC";
        $stmt = $this->db->prepare($sqlMois);
        $stmt->execute(['annee' => $annee]);
        $ventesMois = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $moisPlusRentable = $ventesMois ? $ventesMois[0] : null;

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

        return [
            'ventesMois' => $ventesMois,
            'moisPlusRentable' => $moisPlusRentable,
            'topClients' => $topClients
        ];
    }
}