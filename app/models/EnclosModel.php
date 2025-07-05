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

    public static function getAll(): array
    {
        $conn = Flight::db();
        $stmt = $conn->prepare("SELECT * FROM bao_enclos");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(fn($item) => self::fromArray($item), $result);
    }

    public static function findById(int $id_enclos): ?self
    {
        $conn = Flight::db();
        $sql = "SELECT * FROM bao_enclos WHERE id_enclos = :id_enclos";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id_enclos' => $id_enclos]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ? self::fromArray($result) : null;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id_enclos'] ?? 0,
            $data['enclos_type'] ?? null,
            $data['stockage'] ?? null
        );
    }
}