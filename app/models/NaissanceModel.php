<?php
namespace app\models;

use Flight;

class NaissanceModel
{
    public int $id_portee;
    public int $id_truie;
    public int $id_cycle_reproduction;
    public int $nombre_porcs;
    public ?string $date_naissance;

    public function __construct(int $id_portee, int $id_truie, int $id_cycle_reproduction, int $nombre_porcs, ?string $date_naissance)
    {
        $this->id_portee = $id_portee;
        $this->id_truie = $id_truie;
        $this->id_cycle_reproduction = $id_cycle_reproduction;
        $this->nombre_porcs = $nombre_porcs;
        $this->date_naissance = $date_naissance;
    }

    public static function create(int $id_cycle_reproduction, int $id_truie, int $nombre_porcs, int $id_enclos): bool {
        $conn = Flight::db();
        $stmt = $conn->prepare("INSERT INTO bao_portee (id_truie, id_cycle_reproduction, nombre_porcs, date_naissance) VALUES (:id_truie, :id_cycle_reproduction, :nombre_porcs, CURDATE())");
        $success = $stmt->execute([':id_truie' => $id_truie, ':id_cycle_reproduction' => $id_cycle_reproduction, ':nombre_porcs' => $nombre_porcs]);

        if ($success) {
            $portee_id = $conn->lastInsertId();
            $insertEnclosStmt = $conn->prepare("INSERT INTO bao_enclos_portee (id_enclos, id_portee, quantite_portee, poids_estimation, statut_vente) VALUES (:id_enclos, :id_portee, :quantite_portee, 0, 'non possible')");
            $insertEnclosStmt->execute([':id_enclos' => $id_enclos, ':id_portee' => $portee_id, ':quantite_portee' => $nombre_porcs]);

            CycleModel::updateEtat($id_cycle_reproduction, 'terminée');
            $updateStmt = $conn->prepare("UPDATE bao_cycle_reproduction SET nombre_portee = :nombre_portee, date_fin_cycle = CURDATE() WHERE id_cycle_reproduction = :id_cycle_reproduction");
            $updateStmt->execute([':nombre_portee' => $nombre_porcs, ':id_cycle_reproduction' => $id_cycle_reproduction]);
        }

        return $success;
    }

    public static function fromArray(array $data): NaissanceModel
    {
        return new NaissanceModel(
            $data['id_portee'] ?? 0,
            $data['id_truie'] ?? 0,
            $data['id_cycle_reproduction'] ?? 0,
            $data['nombre_porcs'] ?? 0,
            $data['date_naissance'] ?? null
        );
    }
}