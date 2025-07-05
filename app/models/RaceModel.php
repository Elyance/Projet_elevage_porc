<?php
namespace app\models;

use Flight;
use PDO;

class RaceModel
{
    public static function getAllRaces(): array
    {
        $conn = Flight::db();
        $query = "SELECT id_race, nom_race FROM races_porcs";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function newRace(string $nomRace): bool
    {
        $conn = Flight::db();
        $query = "INSERT INTO races_porcs (nom_race) VALUES (:nom_race)";
        $stmt = $conn->prepare($query);
        return $stmt->execute([':nom_race' => $nomRace]);
    }
}