<?php
namespace app\controllers;

use Flight;
use app\models\Commande;

class CommandeController
{
    public function add()
    {
        $conn = Flight::db();
        try {
            // Récupérer les données de la requête
            $nomClient = Flight::request()->data['nomClient'];
            $id_enclos_portee = Flight::request()->data['id_enclos_portee'];
            $id_race = Flight::request()->data['id_race'];
            $quantite = Flight::request()->data['quantite'];
            $date_commande = Flight::request()->data['date_commande'];
            $adresse_livraison = Flight::request()->data['adresse_livraison'];
            $date_livraison = Flight::request()->data['date_livraison'] ?? null;
            $statut_livraison = Flight::request()->data['statut_livraison'];

            // Démarrer une transaction
            $conn->beginTransaction();

            // Vérifier si la quantité demandée est disponible
            $sql_check = 'SELECT p.nombre_males, ep.quantite_total
                          FROM bao_portee p
                          JOIN bao_enclos_portee ep ON p.id_portee = ep.id_portee
                          WHERE ep.id_enclos_portee = :id_enclos_portee';
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->execute([':id_enclos_portee' => $id_enclos_portee]);
            $result = $stmt_check->fetch(\PDO::FETCH_ASSOC);

            if (!$result) {
                throw new \Exception('Enclos ou portée non trouvé.');
            }

            if ($result['nombre_males'] < $quantite) {
                throw new \Exception('Quantité demandée dépasse le nombre de mâles disponibles.');
            }

            if ($result['quantite_total'] < $quantite) {
                throw new \Exception('Quantité demandée dépasse la quantité totale disponible dans l\'enclos.');
            }

            // Insérer la commande
            $sql_insert = 'INSERT INTO bao_commande 
                           (nomclient, id_enclos_portee, id_race, quantite, date_commande, adresse_livraison, date_livraison, statut_livraison) 
                           VALUES 
                           (:nomclient, :id_enclos_portee, :id_race, :quantite, :date_commande, :adresse_livraison, :date_livraison, :statut_livraison)';
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->execute([
                ':nomclient' => $nomClient,
                ':id_enclos_portee' => $id_enclos_portee,
                ':id_race' => $id_race,
                ':quantite' => $quantite,
                ':date_commande' => $date_commande,
                ':adresse_livraison' => $adresse_livraison,
                ':date_livraison' => $date_livraison,
                ':statut_livraison' => $statut_livraison
            ]);

            // Mettre à jour bao_portee (diminuer nombre_males)
            $sql_update_portee = 'UPDATE bao_portee 
                                  SET nombre_males = nombre_males - :quantite
                                  WHERE id_portee = (SELECT id_portee FROM bao_enclos_portee WHERE id_enclos_portee = :id_enclos_portee)';
            $stmt_update_portee = $conn->prepare($sql_update_portee);
            $stmt_update_portee->execute([
                ':quantite' => $quantite,
                ':id_enclos_portee' => $id_enclos_portee
            ]);

            // Mettre à jour bao_enclos_portee (diminuer quantite_total)
            $sql_update_enclos = 'UPDATE bao_enclos_portee 
                                  SET quantite_total = quantite_total - :quantite
                                  WHERE id_enclos_portee = :id_enclos_portee';
            $stmt_update_enclos = $conn->prepare($sql_update_enclos);
            $stmt_update_enclos->execute([
                ':quantite' => $quantite,
                ':id_enclos_portee' => $id_enclos_portee
            ]);

            // Valider la transaction
            $conn->commit();

            // Rediriger vers la liste des commandes
            Flight::redirect('/commande/list');
        } catch (\Throwable $th) {
            // Annuler la transaction en cas d'erreur
            $conn->rollBack();
            echo $th->getMessage();
        }
    }

    public function list()
    {
        $date_debut = Flight::request()->query['date_debut'] ?? null;
        $date_fin = Flight::request()->query['date_fin'] ?? null;
        $statut = Flight::request()->query['statut'] ?? null;

        $commands = Commande::getAll($date_debut, $date_fin, $statut);

        $data = [
            'commands' => $commands,
            'date_debut' => $date_debut ?? '',
            'date_fin' => $date_fin ?? '',
            'statut' => $statut ?? '',
            'page' => 'commande/liste'
        ];
        Flight::render('commande/liste', $data);
    }

    public function form()
    {
        $clients = Flight::db()->query('SELECT * FROM bao_client')->fetchAll();
        $enclos_portees = Flight::db()->query('SELECT * FROM bao_enclos_portee')->fetchAll();
        $races = Flight::db()->query('SELECT * FROM races_porcs')->fetchAll();

        $data = [
            'clients' => $clients,
            'enclos_portees' => $enclos_portees,
            'races' => $races,
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
                $command->id_race,
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