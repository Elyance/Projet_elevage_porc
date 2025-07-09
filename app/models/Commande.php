<?php

namespace app\models;

use Flight;

class Commande
{
    public int $id_commande;
    public ?int $id_client;
    public ?int $id_enclos_portee;
    public ?int $id_race;
    public ?string $nom_race; // ✅ Ajouté pour stocker le nom de la race
    public ?int $quantite;
    public ?string $date_commande;
    public ?string $adresse_livraison;
    public ?string $date_livraison;
    public ?string $statut_livraison;
    public ?string $nomClient;

    public function __construct(
        int $id_commande,
        ?string $nomClient,
        ?int $id_enclos_portee,
        ?int $id_race,
        ?string $nom_race, // ✅ Ajouté
        ?int $quantite,
        ?string $date_commande,
        ?string $adresse_livraison,
        ?string $date_livraison,
        ?string $statut_livraison
    ) {
        $this->id_commande = $id_commande;
        $this->nomClient = $nomClient;
        $this->id_enclos_portee = $id_enclos_portee;
        $this->id_race = $id_race;
        $this->nom_race = $nom_race; // ✅ Ajouté
        $this->quantite = $quantite;
        $this->date_commande = $date_commande;
        $this->adresse_livraison = $adresse_livraison;
        $this->date_livraison = $date_livraison;
        $this->statut_livraison = $statut_livraison;
    }

    public static function getAll(?string $date_debut = null, ?string $date_fin = null, ?string $statut = null)
    {
        $conn = Flight::db();
        $sql = 'SELECT c.*, r.nom_race 
                FROM bao_commande c 
                LEFT JOIN races_porcs r ON c.id_race = r.id_race 
                WHERE 1=1';
        $params = [];

        if (!empty($date_debut)) {
            $sql .= ' AND c.date_commande >= :date_debut';
            $params[':date_debut'] = $date_debut;
        }
        if (!empty($date_fin)) {
            $sql .= ' AND c.date_commande <= :date_fin';
            $params[':date_fin'] = $date_fin;
        }
        if (!empty($statut)) {
            $sql .= ' AND c.statut_livraison = :statut';
            $params[':statut'] = $statut;
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(fn($item) => self::fromArray($item), $result);
    }

    public static function findById(int $id)
    {
        $conn = Flight::db();
        $sql = 'SELECT c.*, r.nom_race 
                FROM bao_commande c 
                LEFT JOIN races_porcs r ON c.id_race = r.id_race 
                WHERE id_commande = :id';
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ? self::fromArray($result) : null;
    }

    public static function create(
        string $nomClient,
        int $id_enclos_portee,
        int $id_race,
        int $quantite,
        string $date_commande,
        string $adresse_livraison,
        ?string $date_livraison,
        string $statut_livraison
    ) {
        $conn = Flight::db();
        $sql = 'INSERT INTO bao_commande 
                (nomclient, id_enclos_portee, id_race, quantite, date_commande, adresse_livraison, date_livraison, statut_livraison) 
                VALUES 
                (:nomclient, :id_enclos_portee, :id_race, :quantite, :date_commande, :adresse_livraison, :date_livraison, :statut_livraison)';
        $stmt = $conn->prepare($sql);
        try {
            $stmt->execute([
                ':nomclient' => $nomClient,
                ':id_enclos_portee' => $id_enclos_portee,
                ':id_race' => $id_race,
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

    public static function update(
        int $id_commande,
        string $nomClient,
        int $id_enclos_portee,
        int $id_race,
        int $quantite,
        string $date_commande,
        string $adresse_livraison,
        ?string $date_livraison,
        string $statut_livraison
    ) {
        $conn = Flight::db();
        $sql = 'UPDATE bao_commande 
                SET nomclient = :nomclient, 
                    id_enclos_portee = :id_enclos_portee,
                    id_race = :id_race,
                    quantite = :quantite,
                    date_commande = :date_commande,
                    adresse_livraison = :adresse_livraison,
                    date_livraison = :date_livraison,
                    statut_livraison = :statut_livraison 
                WHERE id_commande = :id_commande';
        $stmt = $conn->prepare($sql);
        try {
            $stmt->execute([
                ':id_commande' => $id_commande,
                ':nomclient' => $nomClient,
                ':id_enclos_portee' => $id_enclos_portee,
                ':id_race' => $id_race,
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
            $data['id_enclos_portee'] ?? null,
            $data['id_race'] ?? null,
            $data['nom_race'] ?? null, // ✅ Ajouté
            $data['quantite'] ?? null,
            $data['date_commande'] ?? null,
            $data['adresse_livraison'] ?? null,
            $data['date_livraison'] ?? null,
            $data['statut_livraison'] ?? null,
        );
    }
}