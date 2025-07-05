<?php
namespace app\models;

use Flight;

class TacheModel
{
    public int $id_pesee;
    public int $id_enclos;
    public float $poids;
    public string $date_pesee;

    public function __construct(int $id_pesee, int $id_enclos, float $poids, string $date_pesee)
    {
        $this->id_pesee = $id_pesee;
        $this->id_enclos = $id_enclos;
        $this->poids = $poids;
        $this->date_pesee = $date_pesee;
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
        $stmt = $conn->prepare("INSERT INTO bao_pesee (id_enclos, poids, date_pesee) VALUES (:id_enclos, :poids, :date_pesee)");
        return $stmt->execute([':id_enclos' => $id_enclos, ':poids' => $poids, ':date_pesee' => $date_pesee]);
    }

    public static function fromArray(array $data): TacheModel
    {
        return new TacheModel(
            $data['id_pesee'] ?? 0,
            $data['id_enclos'] ?? 0,
            $data['poids'] ?? 0.0,
            $data['date_pesee'] ?? date('Y-m-d')
        );
    }
}