<?php
namespace app\models;

use Flight;

class ReproductionModel
{
    public int $id_insemination;
    public int $id_truie;
    public ?string $date_insemination;
    public string $resultat;
    public ?float $truie_poids;

    public function __construct(int $id_insemination, int $id_truie, ?string $date_insemination, string $resultat, ?float $truie_poids)
    {
        $this->id_insemination = $id_insemination;
        $this->id_truie = $id_truie;
        $this->date_insemination = $date_insemination;
        $this->resultat = $resultat;
        $this->truie_poids = $truie_poids;
    }

    public static function getAll(array $conditions = []) {
        $conn = Flight::db();
        $query = 'SELECT i.*, t.poids AS truie_poids FROM bao_insemination i JOIN bao_truie t ON i.id_truie = t.id_truie';
        $params = [];

        if (!empty($conditions)) {
            $where = [];
            foreach ($conditions as $key => $value) {
                $where[] = "$key = :$key";
                $params[":$key"] = $value;
            }
            $query .= ' WHERE ' . implode(' AND ', $where);
        }

        echo $query;
        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        // echo print_r($result);
        return array_map(fn($item) => ReproductionModel::fromArray($item), $result);
    }

    public static function create(int $id_truie, string $date_insemination): bool {
        $conn = Flight::db();
        $stmt = $conn->prepare("INSERT INTO bao_insemination (id_truie, date_insemination, resultat) VALUES (:id_truie, :date_insemination, :resultat)");
        return $stmt->execute([':id_truie' => $id_truie, ':date_insemination' => $date_insemination, ':resultat' => 'en cours']);
    }

    public static function updateResult(int $id_insemination, string $resultat): bool {
        $conn = Flight::db();
        $stmt = $conn->prepare("UPDATE bao_insemination SET resultat = :resultat WHERE id_insemination = :id_insemination");
        return $stmt->execute([':resultat' => $resultat, ':id_insemination' => $id_insemination]);
    }

    public static function fromArray(array $data): ReproductionModel
    {
        return new ReproductionModel(
            $data['id_insemination'] ?? 0,
            $data['id_truie'] ?? 0,
            $data['date_insemination'] ?? null,
            $data['resultat'] ?? 'en cours',
            $data['truie_poids'] ?? null
        );
    }
}