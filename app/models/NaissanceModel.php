<?php
namespace app\models;

use Flight;

class NaissanceModel
{
    public int $id_portee;
    public int $id_truie;
    public int $id_cycle_reproduction;
    public int $nombre_males;
    public int $nombre_femelles;
    public ?string $date_naissance;
    public ?int $id_race;

    public function __construct(int $id_portee, int $id_truie, int $id_cycle_reproduction, int $nombre_males, int $nombre_femelles, ?string $date_naissance, ?int $id_race)
    {
        $this->id_portee = $id_portee;
        $this->id_truie = $id_truie;
        $this->id_cycle_reproduction = $id_cycle_reproduction;
        $this->nombre_males = $nombre_males;
        $this->nombre_femelles = $nombre_femelles;
        $this->date_naissance = $date_naissance;
        $this->id_race = $id_race;
    }

    public static function create(int $id_cycle_reproduction, int $id_truie, string $date_naissance, int $femelle_nait, int $male_nait, int $id_enclos, ?int $id_race = null): bool
    {
        $conn = Flight::db();
        try {
            $conn->beginTransaction();

            // Insert into bao_portee with date_naissance and id_race
            $sqlInsertPortee = "INSERT INTO bao_portee (id_truie, id_cycle_reproduction, nombre_males, nombre_femelles, date_naissance, id_race) 
                                VALUES (:id_truie, :id_cycle_reproduction, :nombre_males, :nombre_femelles, :date_naissance, :id_race) 
                                RETURNING id_portee";
            $stmt = $conn->prepare($sqlInsertPortee);
            $stmt->execute([
                ':id_truie' => $id_truie,
                ':id_cycle_reproduction' => $id_cycle_reproduction,
                ':nombre_males' => $male_nait,
                ':nombre_femelles' => $femelle_nait,
                ':date_naissance' => $date_naissance,
                ':id_race' => $id_race ?? 1
            ]);
            $portee_id = $stmt->fetchColumn();

            if ($portee_id) {
                // Directly assign to enclosure via bao_enclos_portee
                $quantite_total = $male_nait + $femelle_nait;
                $insertEnclosStmt = $conn->prepare(
                    "INSERT INTO bao_enclos_portee (id_enclos, id_portee, quantite_total,  poids_estimation, statut_vente, nombre_jour_ecoule) 
                     VALUES (:id_enclos, :id_portee, :quantite_total,  0, 'non possible', 0)"
                );
                $insertEnclosStmt->execute([
                    ':id_enclos' => $id_enclos,
                    ':id_portee' => $portee_id,
                    ':quantite_total' => $quantite_total,
                ]);

                // Update cycle with the provided date_naissance
                CycleModel::updateEtat($id_cycle_reproduction, 'termine');
                $updateStmt = $conn->prepare(
                    "UPDATE bao_cycle_reproduction 
                     SET nombre_males = :nombre_males, nombre_femelles = :nombre_femelles, date_fin_cycle = :date_fin_cycle 
                     WHERE id_cycle_reproduction = :id_cycle_reproduction"
                );
                $updateStmt->execute([
                    ':nombre_males' => $male_nait,
                    ':nombre_femelles' => $femelle_nait,
                    ':date_fin_cycle' => $date_naissance,
                    ':id_cycle_reproduction' => $id_cycle_reproduction
                ]);

                $conn->commit();
                return true;
            }
            $conn->rollBack();
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
            $data['date_naissance'] ?? null,
            $data['id_race'] ?? 1
        );
    }
}