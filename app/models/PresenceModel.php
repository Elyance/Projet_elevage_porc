<?php
namespace app\models;

use Flight;

class PresenceModel
{
    public int $id_presence;
    public int $id_employe;
    public string $date_presence;
    public string $statut;

    public function __construct(int $id_presence, int $id_employe, string $date_presence, string $statut)
    {
        $this->id_presence = $id_presence;
        $this->id_employe = $id_employe;
        $this->date_presence = $date_presence;
        $this->statut = $statut;
    }

    public static function getAll(array $conditions = [])
    {
        $conn = Flight::db();
        $query = "SELECT * FROM bao_presence";
        $params = [];

        if (!empty($conditions)) {
            $where = [];
            foreach ($conditions as $key => $value) {
                if (strpos($key, ' ') !== false) {
                    // Handle range conditions (e.g., "date_presence >=")
                    [$column, $operator] = explode(' ', $key, 2);
                    $paramName = $column . '_' . str_replace('=', '', $operator); // e.g., "date_presence_ge" for ">="
                    $where[] = "$column $operator :$paramName";
                    $params[":$paramName"] = $value;
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
        return array_map(fn($item) => PresenceModel::fromArray($item), $result);
    }
    public static function getDaysPresentByEmployeeAndMonth(int $id_employe, string $start_date, string $end_date): array
    {
        $conn = Flight::db();
        $query = "SELECT * FROM bao_presence 
                  WHERE id_employe = :id_employe 
                  AND date_presence >= :start_date 
                  AND date_presence <= :end_date";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ":id_employe" => $id_employe,
            ":start_date" => $start_date,
            ":end_date" => $end_date
        ]);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(fn($item) => PresenceModel::fromArray($item), $result);
    }
    public static function getPresenceStatus(int $id_employe, string $date): ?string
    {
        $conn = Flight::db();
        $query = "SELECT statut FROM bao_presence 
                  WHERE id_employe = :id_employe 
                  AND date_presence = :date 
                  LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ":id_employe" => $id_employe,
            ":date" => $date
        ]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ? $result["statut"] : "absent"; // Default to "absent" if no record
    }

    public static function create(int $id_employe, string $date_presence, string $statut): bool
    {
        $conn = Flight::db();
        $stmt = $conn->prepare("INSERT INTO bao_presence (id_employe, date_presence, statut) 
                               VALUES (:id_employe, :date_presence, :statut)");
        return $stmt->execute([
            ":id_employe" => $id_employe,
            ":date_presence" => $date_presence,
            ":statut" => $statut
        ]);
    }

    public static function updateStatut(int $id_presence, string $statut): bool
    {
        $conn = Flight::db();
        $stmt = $conn->prepare("UPDATE bao_presence SET statut = :statut WHERE id_presence = :id_presence");
        return $stmt->execute([":statut" => $statut, ":id_presence" => $id_presence]);
    }

    public static function fromArray(array $data): PresenceModel
    {
        return new PresenceModel(
            $data["id_presence"] ?? 0,
            $data["id_employe"] ?? 0,
            $data["date_presence"] ?? "",
            $data["statut"] ?? "absent"
        );
    }
}