<?php
namespace app\models;

use Flight;

class EmployeModel
{
    public int $id_employe;
    public string $nom_employe;
    public string $prenom_employe;
    public int $id_employe_poste;
    public string $adresse;
    public string $contact_telephone;
    public string $date_recrutement;
    public ?string $date_retirer;
    public string $statut;
    public ?string $nom_poste; // From join with bao_employe_poste

    public function __construct(
        int $id_employe,
        string $nom_employe,
        string $prenom_employe,
        int $id_employe_poste,
        string $adresse,
        string $contact_telephone,
        string $date_recrutement,
        ?string $date_retirer,
        string $statut,
        ?string $nom_poste = null
    ) {
        $this->id_employe = $id_employe;
        $this->nom_employe = $nom_employe;
        $this->prenom_employe = $prenom_employe;
        $this->id_employe_poste = $id_employe_poste;
        $this->adresse = $adresse;
        $this->contact_telephone = $contact_telephone;
        $this->date_recrutement = $date_recrutement;
        $this->date_retirer = $date_retirer;
        $this->statut = $statut;
        $this->nom_poste = $nom_poste;
    }

    public static function getAll(array $conditions = [])
    {
        $conn = Flight::db();
        $query = "SELECT e.*, p.nom_poste FROM bao_employe e LEFT JOIN bao_employe_poste p ON e.id_employe_poste = p.id_employe_poste";
        $params = [];

        if (!empty($conditions)) {
            $where = [];
            foreach ($conditions as $key => $value) {
                $where[] = "e.$key = :$key";
                $params[":$key"] = $value;
            }
            $query .= " WHERE " . implode(" AND ", $where);
        }

        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(fn($item) => EmployeModel::fromArray($item), $result);
    }

    public static function create(
        string $nom_employe,
        string $prenom_employe,
        int $id_employe_poste,
        string $adresse,
        string $contact_telephone,
        string $date_recrutement,
        string $statut
    ): bool {
        $conn = Flight::db();
        $stmt = $conn->prepare(
            "INSERT INTO bao_employe (nom_employe, prenom_employe, id_employe_poste, adresse, contact_telephone, date_recrutement, statut) 
             VALUES (:nom_employe, :prenom_employe, :id_employe_poste, :adresse, :contact_telephone, :date_recrutement, :statut)"
        );
        return $stmt->execute([
            ":nom_employe" => $nom_employe,
            ":prenom_employe" => $prenom_employe,
            ":id_employe_poste" => $id_employe_poste,
            ":adresse" => $adresse,
            ":contact_telephone" => $contact_telephone,
            ":date_recrutement" => $date_recrutement,
            ":statut" => $statut
        ]);
    }

    public static function updateStatut(int $id_employe, string $statut, ?string $date_retirer = null): bool
    {
        $conn = Flight::db();
        $stmt = $conn->prepare("UPDATE bao_employe SET statut = :statut, date_retirer = :date_retirer WHERE id_employe = :id_employe");
        return $stmt->execute([
            ":statut" => $statut,
            ":date_retirer" => $date_retirer,
            ":id_employe" => $id_employe
        ]);
    }

    public static function fromArray(array $data): EmployeModel
    {
        return new EmployeModel(
            $data["id_employe"] ?? 0,
            $data["nom_employe"] ?? "",
            $data["prenom_employe"] ?? "",
            $data["id_employe_poste"] ?? 0,
            $data["adresse"] ?? "",
            $data["contact_telephone"] ?? "",
            $data["date_recrutement"] ?? "",
            $data["date_retirer"] ?? null,
            $data["statut"] ?? "actif",
            $data["nom_poste"] ?? null
        );
    }
}