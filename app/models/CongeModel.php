<?php
namespace app\models;

use Flight;
use PDO;

class CongeModel
{
    public int $id_conge;
    public int $id_employe;
    public string $date_debut;
    public string $date_fin;
    public string $motif;
    public string $statut;

    public function __construct(int $id_conge, int $id_employe, string $date_debut, string $date_fin, string $motif, string $statut)
    {
        $this->id_conge = $id_conge;
        $this->id_employe = $id_employe;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->motif = $motif;
        $this->statut = $statut;
    }

    public static function create(int $id_employe, string $date_debut, string $date_fin, string $motif, string $statut = "valide"): bool
    {
        $conn = Flight::db();
        $stmt = $conn->prepare("INSERT INTO bao_conge (id_employe, date_debut, date_fin, motif, statut) 
                               VALUES (:id_employe, :date_debut::date, :date_fin::date, :motif, :statut)");
        return $stmt->execute([
            ":id_employe" => $id_employe,
            ":date_debut" => $date_debut,
            ":date_fin" => $date_fin,
            ":motif" => $motif,
            ":statut" => $statut
        ]);
    }

    public static function fromArray(array $data): CongeModel
    {
        return new CongeModel(
            $data["id_conge"] ?? 0,
            $data["id_employe"] ?? 0,
            $data["date_debut"] ?? "",
            $data["date_fin"] ?? "",
            $data["motif"] ?? "",
            $data["statut"] ?? "en attente"
        );
    }
}