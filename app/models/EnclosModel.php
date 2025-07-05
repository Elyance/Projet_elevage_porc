<?php
namespace app\models;

use Flight;

class EnclosModel
{
    public int $id_enclos;
    public ?int $enclos_type;
    public ?int $stockage;

    public function __construct(int $id_enclos, ?int $enclos_type, ?int $stockage)
    {
        $this->id_enclos = $id_enclos;
        $this->enclos_type = $enclos_type;
        $this->stockage = $stockage;
    }

    public static function getAll() {
        $conn = Flight::db();
        $stmt = $conn->query("SELECT * FROM bao_enclos");
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(fn($item) => EnclosModel::fromArray($item), $result);
    }

    public static function fromArray(array $data): EnclosModel
    {
        return new EnclosModel(
            $data['id_enclos'] ?? 0,
            $data['enclos_type'] ?? null,
            $data['stockage'] ?? null
        );
    }
}