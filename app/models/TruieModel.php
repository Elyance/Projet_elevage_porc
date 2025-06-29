<?php
namespace app\models;

use Flight;

class TruieModel
{
    public int $id_truie;
    public ?float $poids;
    public ?string $date_entree;
    public ?int $id_enclos;

    public function __construct(int $id_truie, ?float $poids, ?string $date_entree, ?int $id_enclos)
    {
        $this->id_truie = $id_truie;
        $this->poids = $poids;
        $this->date_entree = $date_entree;
        $this->id_enclos = $id_enclos;
    }

    public static function getAll() {
        $conn = Flight::db();
        $stmt = $conn->query("SELECT * FROM bao_truie");
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(fn($item) => TruieModel::fromArray($item), $result);
    }

    public static function fromArray(array $data): TruieModel
    {
        return new TruieModel(
            $data['id_truie'] ?? 0,
            $data['poids'] ?? null,
            $data['date_entree'] ?? null,
            $data['id_enclos'] ?? null
        );
    }
}