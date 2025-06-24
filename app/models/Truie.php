<?php

namespace app\models;
use Flight;

class Truie
{
    public int $id;
    public string $nom;
    public string $race;

    public function __construct(int $id, string $nom, string $race)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->race = $race;
    }

    public static function getAll() {
        $conn = Flight::db();
        $stmt = $conn->prepare("SELECT * FROM truie");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(fn($item) => Truie::fromArray($item), $result);
    }

    public static function fromArray(array $data): Truie
    {
        return new Truie(
            $data['id'] ?? 0,
            $data['nom'] ?? '',
            $data['race'] ?? ''
        );
    }
}