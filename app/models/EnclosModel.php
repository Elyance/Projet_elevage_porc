<?php
namespace app\models;

use Flight;

class EnclosModel
{
    public int $id_enclos;
    public ?int $enclos_type;
    public ?int $surface;

    public function __construct(int $id_enclos, ?int $enclos_type, ?int $surface)
    {
        $this->id_enclos = $id_enclos;
        $this->enclos_type = $enclos_type;
        $this->surface = $surface;
    }

    public static function getAll(): array
    {
        $conn = Flight::db();
        $stmt = $conn->prepare("SELECT * FROM bao_enclos");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(fn($item) => self::fromArray($item), $result);
    }
    public static function getAll2()
{
    $conn = Flight::db();
    $stmt = $conn->query("SELECT id_enclos, enclos_type, surface FROM bao_enclos");
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
            $data['surface'] ?? null
        );
    }

    public static function delete($id)
    {
        $stmt = \Flight::db()->prepare('DELETE FROM bao_enclos WHERE id_enclos = ?');

        return $stmt->execute([$id]);
    }

    public static function update($id, $enclos_type, $surface)
    {
        $stmt = \Flight::db()->prepare('UPDATE bao_enclos SET enclos_type = ?, surface = ? WHERE id_enclos = ?');

        return $stmt->execute([$enclos_type, $surface, $id]);
    }

    public static function getAllTsyArray()
    {
        $stmt = \Flight::db()->query('select * from bao_enclos JOIN bao_enclos_type on bao_enclos.enclos_type = bao_enclos_type.id_enclos_type');

        return $stmt->fetchAll();
    }

    public static function create($type_enclos, $surface)
    {
        $stmt = \Flight::db()->prepare('INSERT INTO bao_enclos(enclos_type, surface) VALUES (?,?)');

        return $stmt->execute([$type_enclos, $surface]);
    }

    public static function findByIdJoined($id)
    {
        $stmt = \Flight::db()->prepare('SELECT * FROM bao_enclos JOIN bao_enclos_type ON bao_enclos_type.id_enclos_type = bao_enclos.enclos_type  WHERE id_enclos = ?');
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        return $result;
    }

    // public static function findById($id)
    // {
    //     $stmt = \Flight::db()->prepare('SELECT * FROM bao_enclos WHERE id_enclos = ?');
    //     $stmt->execute([$id]);
    //     $result = $stmt->fetch();

    //     return $result;
    // }
}
