<?php

namespace app\models;

use Flight;

class Commande
{
    public int $id_commande;
    public ?int $id_client;
    public ?int $id_enclos_portee;
    public ?int $quantite;
    public ?string $date_commande;
    public ?string $adresse_livraison;
    public ?string $date_livraison;
    public ?string $statut_livraison;
    // public ?string $nom_client; // Ajout pour la jointure
    public ?string $nomClient;

    public function __construct(
        int $id_commande,
        // ?int $id_client,
        ?string $nomClient,
        ?int $id_enclos_portee,
        ?int $quantite,
        ?string $date_commande,
        ?string $adresse_livraison,
        ?string $date_livraison,
        ?string $statut_livraison,
        // ?string $nom_client = null
    ) {
        $this->id_commande = $id_commande;
        $this->nomClient = $nomClient;
        // $this->id_client = $id_client;
        $this->id_enclos_portee = $id_enclos_portee;
        $this->quantite = $quantite;
        $this->date_commande = $date_commande;
        $this->adresse_livraison = $adresse_livraison;
        $this->date_livraison = $date_livraison;
        $this->statut_livraison = $statut_livraison;
        // $this->nom_client = $nom_client;
    }

    public static function getAll()
    {
        $conn = Flight::db();

        // $sql = 'SELECT c.*, cl.nom_client 
        //         FROM bao_commande c 
        //         LEFT JOIN bao_client cl ON c.id_client = cl.id_client';

        $sql = 'SELECT * FROM bao_commande';

        $result = $conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(fn($item) => self::fromArray($item), $result);
    }

    public static function findById(int $id)
    {
        $conn = Flight::db();
        // $sql = 'SELECT c.*, cl.nom_client 
        //         FROM bao_commande c 
        //         LEFT JOIN bao_client cl ON c.id_client = cl.id_client 
        //         WHERE c.id_commande = :id';
        $sql = 'SELECT * FROM bao_commande c WHERE c.id_commande = :id';

        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ? self::fromArray($result) : null;
    }

    // public static function create(int $id_client, int $id_enclos_portee, int $quantite, string $date_commande, string $adresse_livraison, ?string $date_livraison, string $statut_livraison)
    // {
    //     $conn = Flight::db();
    //     $sql = 'INSERT INTO bao_commande (id_client, id_enclos_portee, quantite, date_commande, adresse_livraison, date_livraison, statut_livraison) 
    //             VALUES (:id_client, :id_enclos_portee, :quantite, :date_commande, :adresse_livraison, :date_livraison, :statut_livraison)';
    //     $stmt = $conn->prepare($sql);
    //     try {
    //         $stmt->execute([
    //             ':id_client' => $id_client,
    //             ':id_enclos_portee' => $id_enclos_portee,
    //             ':quantite' => $quantite,
    //             ':date_commande' => $date_commande,
    //             ':adresse_livraison' => $adresse_livraison,
    //             ':date_livraison' => $date_livraison,
    //             ':statut_livraison' => $statut_livraison
    //         ]);
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }

    public static function create(string $nomClient,int $id_enclos_portee, int $quantite, string $date_commande, string $adresse_livraison, ?string $date_livraison, string $statut_livraison){
        $conn = Flight::db();
        $sql = 'INSERT INTO bao_commande (nomclient, id_enclos_portee, quantite, date_commande, adresse_livraison, date_livraison, statut_livraison) 
                VALUES (:nomclient, :id_enclos_portee, :quantite, :date_commande, :adresse_livraison, :date_livraison, :statut_livraison)';
        $stmt = $conn->prepare($sql);
        try {
            $stmt->execute([
                ':nomclient' => $nomClient,
                ':id_enclos_portee' => $id_enclos_portee,
                ':quantite' => $quantite,
                ':date_commande' => $date_commande,
                ':adresse_livraison' => $adresse_livraison,
                ':date_livraison' => $date_livraison,
                ':statut_livraison' => $statut_livraison
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function update(int $id_commande, string $nomClient, int $id_enclos_portee, int $quantite, string $date_commande, string $adresse_livraison, ?string $date_livraison, string $statut_livraison)
    {
        $conn = Flight::db();
        $sql = 'UPDATE bao_commande 
                SET nomclient = :nomclient, id_enclos_portee = :id_enclos_portee, quantite = :quantite, 
                    date_commande = :date_commande, adresse_livraison = :adresse_livraison, 
                    date_livraison = :date_livraison, statut_livraison = :statut_livraison 
                WHERE id_commande = :id_commande';
        $stmt = $conn->prepare($sql);
        try {
            $stmt->execute([
                ':id_commande' => $id_commande,
                ':nomclient' => $nomClient,
                ':id_enclos_portee' => $id_enclos_portee,
                ':quantite' => $quantite,
                ':date_commande' => $date_commande,
                ':adresse_livraison' => $adresse_livraison,
                ':date_livraison' => $date_livraison,
                ':statut_livraison' => $statut_livraison
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function delete(int $id)
    {
        $conn = Flight::db();
        $sql = 'DELETE FROM bao_commande WHERE id_commande = :id';
        $stmt = $conn->prepare($sql);
        try {
            $stmt->execute([':id' => $id]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function fromArray(array $data): Commande
    {
        return new Commande(
            $data['id_commande'] ?? 0,
            $data['nomclient'] ?? null,

            // $data['id_client'] ?? null,
            $data['id_enclos_portee'] ?? null,
            $data['quantite'] ?? null,
            $data['date_commande'] ?? null,
            $data['adresse_livraison'] ?? null,
            $data['date_livraison'] ?? null,
            $data['statut_livraison'] ?? null,
        );
    }
}