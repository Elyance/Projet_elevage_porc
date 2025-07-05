<?php
namespace app\models;

use Flight;

class NaissanceModel
{
    public int $id_portee;
    public int $id_truie;
    public int $id_cycle_reproduction;
    public int $nombre_males; // Updated from nombre_porcs
    public int $nombre_femelles; // New field
    public ?string $date_naissance;

    public function __construct(int $id_portee, int $id_truie, int $id_cycle_reproduction, int $nombre_males, int $nombre_femelles, ?string $date_naissance)
    {
        $this->id_portee = $id_portee;
        $this->id_truie = $id_truie;
        $this->id_cycle_reproduction = $id_cycle_reproduction;
        $this->nombre_males = $nombre_males;
        $this->nombre_femelles = $nombre_femelles;
        $this->date_naissance = $date_naissance;
    }

    public static function create(int $id_cycle_reproduction, int $id_truie, int $femelle_nait, int $male_nait, int $id_enclos): bool
    {
        $conn = Flight::db();
        // $db->beginTransaction(); // Added transaction handling
        try {
            // Insertion dans bao_portee
            $sqlInsertPortee = "INSERT INTO bao_portee (id_truie, id_cycle_reproduction, nombre_males, nombre_femelles, date_naissance) 
                                VALUES (:id_truie, :id_cycle_reproduction, :nombre_males, :nombre_femelles, CURRENT_DATE) 
                                RETURNING id_portee";
            $stmt = $conn->prepare($sqlInsertPortee);
            $stmt->execute([
                ':id_truie' => $id_truie,
                ':id_cycle_reproduction' => $id_cycle_reproduction,
                ':nombre_males' => $male_nait,
                ':nombre_femelles' => $femelle_nait
            ]);
            $portee_id = $stmt->fetchColumn();

            if ($portee_id) {
                // Insertion dans bao_enclos_portee
                $insertEnclosStmt = $conn->prepare(
                    "INSERT INTO bao_enclos_portee (id_enclos, id_portee, quantite_males, quantite_femelles, poids_estimation, statut_vente) 
                     VALUES (:id_enclos, :id_portee, :quantite_males, :quantite_femelles, 0, 'non possible')"
                );
                $insertEnclosStmt->execute([
                    ':id_enclos' => $id_enclos,
                    ':id_portee' => $portee_id,
                    ':quantite_males' => $male_nait,
                    ':quantite_femelles' => $femelle_nait
                ]);

                // Mettre à jour le cycle
                CycleModel::updateEtat($id_cycle_reproduction, 'termine');
                $updateStmt = $conn->prepare(
                    "UPDATE bao_cycle_reproduction 
                     SET nombre_males = :nombre_males, nombre_femelles = :nombre_femelles, date_fin_cycle = CURRENT_DATE 
                     WHERE id_cycle_reproduction = :id_cycle_reproduction"
                );
                $updateStmt->execute([
                    ':nombre_males' => $male_nait,
                    ':nombre_femelles' => $femelle_nait,
                    ':id_cycle_reproduction' => $id_cycle_reproduction
                ]);

                return true;
            }
            return false;
        } catch (\Exception $e) {
            $conn->rollBack();
            error_log('Error in NaissanceModel::create(): ' . $e->getMessage());
            return false;
        }
    }

    public static function fromArray(array $data): NaissanceModel
    {
        return new NaissanceModel(
            $data['id_portee'] ?? 0,
            $data['id_truie'] ?? 0,
            $data['id_cycle_reproduction'] ?? 0,
            $data['nombre_males'] ?? 0,
            $data['nombre_femelles'] ?? 0,
            $data['date_naissance'] ?? null
        );
    }
}