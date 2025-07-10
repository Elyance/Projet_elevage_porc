<?php
namespace app\models;

use Flight;

class TacheModel
{
    public int $id_pesee;
    public int $id_enclos;
    public float $poids;
    public string $date_pesee;
    public string $created_at;

    public function __construct(int $id_pesee, int $id_enclos, float $poids, string $date_pesee, string $created_at)
    {
        $this->id_pesee = $id_pesee;
        $this->id_enclos = $id_enclos;
        $this->poids = $poids;
        $this->date_pesee = $date_pesee;
        $this->created_at = $created_at;
    }

    public static function getAll(array $conditions = []) {
        $conn = Flight::db();
        $query = 'SELECT * FROM bao_pesee';
        $params = [];

        if (!empty($conditions)) {
            $where = [];
            foreach ($conditions as $key => $value) {
                $where[] = "$key = :$key";
                $params[":$key"] = $value;
            }
            $query .= ' WHERE ' . implode(' AND ', $where);
        }

        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(fn($item) => TacheModel::fromArray($item), $result);
    }

    public static function create(int $id_enclos, float $poids, string $date_pesee): bool {
        $conn = Flight::db();
        $stmt = $conn->prepare("INSERT INTO bao_pesee (id_enclos, poids, date_pesee, created_at) 
                                VALUES (:id_enclos, :poids, :date_pesee, :created_at)");
        return $stmt->execute([
            ':id_enclos' => $id_enclos,
            ':poids' => $poids,
            ':date_pesee' => $date_pesee,
            ':created_at' => date('Y-m-d H:i:s') // you can also pass it as parameter
        ]);
    }

    public static function fromArray(array $data): TacheModel
    {
        return new TacheModel(
            $data['id_pesee'] ?? 0,
            $data['id_enclos'] ?? 0,
            $data['poids'] ?? 0.0,
            $data['date_pesee'] ?? date('Y-m-d'),
            $data['created_at'] ?? date('Y-m-d H:i:s') // default to now if not set
        );
    }
    // Existing methods remain unchanged, but add methods for task assignments with precision
    public static function assignTache(array $data) {
        $conn = Flight::db();
        $stmt = $conn->prepare("INSERT INTO bao_tache_employe (id_employe, id_tache, date_echeance, precision) 
                               VALUES (:id_employe, :id_tache, :date_echeance, :precision)");
        return $stmt->execute([
            ':id_employe' => $data['id_employe'],
            ':id_tache' => $data['id_tache'],
            ':date_echeance' => $data['date_echeance'],
            ':precision' => $data['precision'] ?? ''
        ]);
    }

    public static function getTachesEmploye(int $id_employe) {
    $conn = Flight::db();
    $stmt = $conn->prepare("SELECT t.*, te.date_echeance, te.precision, te.statut 
                           FROM bao_tache t 
                           JOIN bao_tache_employe te ON t.id_tache = te.id_tache 
                           WHERE te.id_employe = :id_employe");
    $stmt->execute([':id_employe' => $id_employe]);
    $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    // Normalize date_echeance to Y-m-d if it's a DATETIME
    foreach ($results as &$row) {
        $row['date_echeance'] = date('Y-m-d', strtotime($row['date_echeance']));
    }
    return $results;
}
}