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
                    Flight::request()->data['id_client'],
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
        $sql = 'SELECT c.*, cl.nom_client 
                FROM bao_commande c 
                LEFT JOIN bao_client cl ON c.id_client = cl.id_client';
        $commands = $conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        $data = [
            'commands' => array_map(fn($item) => Commande::fromArray($item), $commands),
            'page' => 'commande/liste'
        ];
        Flight::render('commande/liste', $data);
    }
    public function form(){
        $clients = Flight::db()->query('SELECT * FROM bao_client')->fetchAll();
                $enclos_portees = Flight::db()->query('SELECT * FROM bao_enclos_portee')->fetchAll();
                $data = [
                    'clients' => $clients,
                    'enclos_portees' => $enclos_portees,
                    'page' => 'commande/commande'
                ];
                Flight::render('commande/commande',$data);
    }

    public function recette()
    {
        $recettes = Flight::db()->query('SELECT * FROM bao_recette')->fetchAll();
        $data = [
            'recettes' => $recettes,
            'page' => 'commande/recette'
        ];
        Flight::render('commande/recette', $data);
    }
}

?>