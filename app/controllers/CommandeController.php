<?php
namespace app\controllers;

use Flight;
use app\models\Commande; 

class CommandeController
{
    public function add()
    {
        try {
            Commande::create(
                Flight::request()->data['nomClient'],
                Flight::request()->data['id_enclos_portee'],
                Flight::request()->data['quantite'],
                Flight::request()->data['date_commande'],
                Flight::request()->data['adresse_livraison'],
                Flight::request()->data['date_livraison'] ?? null,
                Flight::request()->data['statut_livraison']
            );
            Flight::redirect('/commande/list');
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    } 

    public function list()
    {
        $conn = Flight::db();
        $sql = 'SELECT * FROM bao_commande';
        $commands = $conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        $data = [
            'commands' => array_map(fn($item) => Commande::fromArray($item), $commands),
            'page' => 'commande/liste'
        ];
        Flight::render('commande/liste', $data);
    }

    public function form()
    {
        $clients = Flight::db()->query('SELECT * FROM bao_client')->fetchAll();
        $enclos_portees = Flight::db()->query('SELECT * FROM bao_enclos_portee')->fetchAll();
        $data = [
            'clients' => $clients,
            'enclos_portees' => $enclos_portees,
            'page' => 'commande/commande'
        ];
        Flight::render('commande/commande', $data);
    }

    public function editStatus($id)
    {
        $command = Commande::findById($id);
        if (!$command) {
            Flight::halt(404, 'Commande non trouvée');
        }
        $data = [
            'command' => $command,
            'page' => 'commande/edit_status'
        ];
        Flight::render('commande/edit_status', $data);
    }

    public function updateStatus($id)
    {
        try {
            $command = Commande::findById($id);
            if (!$command) {
                Flight::halt(404, 'Commande non trouvée');
            }
            Commande::update(
                $id,
                $command->nomClient,
                $command->id_enclos_portee,
                $command->quantite,
                $command->date_commande,
                $command->adresse_livraison,
                $command->date_livraison,
                Flight::request()->data['statut_livraison']
            );
            Flight::redirect('/commande/list');
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function recette()
    {
        $conn = Flight::db();
        $sql = 'SELECT * FROM bao_view_recette WHERE 1=1';
        $sql_total = 'SELECT SUM(prix_total) as total FROM bao_view_recette WHERE 1=1';
        $params = [];

        if (!empty(Flight::request()->query['date_debut'])) {
            $sql .= ' AND date_recette >= :date_debut';
            $sql_total .= ' AND date_recette >= :date_debut';
            $params[':date_debut'] = Flight::request()->query['date_debut'];
        }
        if (!empty(Flight::request()->query['date_fin'])) {
            $sql .= ' AND date_recette <= :date_fin';
            $sql_total .= ' AND date_recette <= :date_fin';
            $params[':date_fin'] = Flight::request()->query['date_fin'];
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $recettes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $stmt_total = $conn->prepare($sql_total);
        $stmt_total->execute($params);
        $total_recette = $stmt_total->fetch(\PDO::FETCH_ASSOC)['total'] ?? 0;

        $data = [
            'recettes' => $recettes,
            'date_debut' => Flight::request()->query['date_debut'] ?? '',
            'date_fin' => Flight::request()->query['date_fin'] ?? '',
            'total_recette' => $total_recette,
            'page' => 'commande/recette'
        ];
        Flight::render('commande/recette', $data);
    }
}
?>