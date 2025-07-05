<?php
namespace app\models;

use Flight;

class SalaireModel
{
    public int $id_salaire;
    public int $id_employe;
    public string $date_salaire;
    public float $montant;
    public string $statut;

    public function __construct(int $id_salaire, int $id_employe, string $date_salaire, float $montant, string $statut)
    {
        $this->id_salaire = $id_salaire;
        $this->id_employe = $id_employe;
        $this->date_salaire = $date_salaire;
        $this->montant = $montant;
        $this->statut = $statut;
    }

    public static function getAll(array $conditions = [])
    {
        $conn = Flight::db();
        $query = "SELECT * FROM bao_salaire";
        $params = [];

        if (!empty($conditions)) {
            $where = [];
            foreach ($conditions as $key => $value) {
                if ($key === "date_salaire LIKE") {
                    $where[] = "date_salaire LIKE :date_salaire";
                    $params[":date_salaire"] = $value;
                } else {
                    $where[] = "$key = :$key";
                    $params[":$key"] = $value;
                }
            }
            $query .= " WHERE " . implode(" AND ", $where);
        }

        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(fn($item) => SalaireModel::fromArray($item), $result);
    }

    public static function create(int $id_employe, string $date_salaire, float $montant, string $statut): bool
    {
        $conn = Flight::db();
        $stmt = $conn->prepare("INSERT INTO bao_salaire (id_employe, date_salaire, montant, statut) 
                               VALUES (:id_employe, :date_salaire, :montant, :statut)");
        return $stmt->execute([
            ":id_employe" => $id_employe,
            ":date_salaire" => $date_salaire,
            ":montant" => $montant,
            ":statut" => $statut
        ]);
    }

    public static function updateStatut(int $id_salaire, string $statut): bool
    {
        $conn = Flight::db();
        $stmt = $conn->prepare("UPDATE bao_salaire SET statut = :statut WHERE id_salaire = :id_salaire");
        return $stmt->execute([":statut" => $statut, ":id_salaire" => $id_salaire]);
    }

    public static function fromArray(array $data): SalaireModel
    {
        return new SalaireModel(
            $data["id_salaire"] ?? 0,
            $data["id_employe"] ?? 0,
            $data["date_salaire"] ?? "",
            $data["montant"] ?? 0.0,
            $data["statut"] ?? "non payé"
        );
    }
}