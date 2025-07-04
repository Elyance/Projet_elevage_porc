<?php
namespace app\models;

use Flight;

class EmployePosteModel
{
    public int $id_employe_poste;
    public string $nom_poste;
    public float $salaire_base;

    public function __construct(int $id_employe_poste, string $nom_poste, float $salaire_base)
    {
        $this->id_employe_poste = $id_employe_poste;
        $this->nom_poste = $nom_poste;
        $this->salaire_base = $salaire_base;
    }

    public static function getAll(array $conditions = [])
    {
        $conn = Flight::db();
        $query = "SELECT * FROM bao_employe_poste";
        $params = [];

        if (!empty($conditions)) {
            $where = [];
            foreach ($conditions as $key => $value) {
                $where[] = "$key = :$key";
                $params[":$key"] = $value;
            }
            $query .= " WHERE " . implode(" AND ", $where);
        }

        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(fn($item) => EmployePosteModel::fromArray($item), $result);
    }

    public static function create(string $nom_poste, float $salaire_base): bool
    {
        $conn = Flight::db();
        $stmt = $conn->prepare("INSERT INTO bao_employe_poste (nom_poste, salaire_base) VALUES (:nom_poste, :salaire_base)");
        return $stmt->execute([":nom_poste" => $nom_poste, ":salaire_base" => $salaire_base]);
    }

    public static function fromArray(array $data): EmployePosteModel
    {
        return new EmployePosteModel(
            $data["id_employe_poste"] ?? 0,
            $data["nom_poste"] ?? "",
            $data["salaire_base"] ?? 0.0
        );
    }
}