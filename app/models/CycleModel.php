<?php
namespace app\models;

use Flight;

class CycleModel
{
    public int $id_cycle_reproduction;
    public int $id_truie;
    public ?string $date_debut_cycle;
    public ?string $date_fin_cycle;
    public ?int $nombre_males; // Updated from nombre_portee to match bao_portee
    public ?int $nombre_femelles; // New field
    public ?int $id_insemination;
    public string $etat;
    public ?float $truie_poids;

    public function __construct(
        int $id_cycle_reproduction,
        int $id_truie,
        ?string $date_debut_cycle,
        ?string $date_fin_cycle,
        ?int $nombre_males,
        ?int $nombre_femelles,
        ?int $id_insemination,
        string $etat,
        ?float $truie_poids
    ) {
        $this->id_cycle_reproduction = $id_cycle_reproduction;
        $this->id_truie = $id_truie;
        $this->date_debut_cycle = $date_debut_cycle;
        $this->date_fin_cycle = $date_fin_cycle;
        $this->nombre_males = $nombre_males;
        $this->nombre_femelles = $nombre_femelles;
        $this->id_insemination = $id_insemination;
        $this->etat = $etat;
        $this->truie_poids = $truie_poids;
    }

    public static function getAll()
    {
        $conn = Flight::db();
        $stmt = $conn->prepare("SELECT c.*, t.poids AS truie_poids FROM bao_cycle_reproduction c JOIN bao_truie t ON c.id_truie = t.id_truie");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(fn($item) => CycleModel::fromArray($item), $result);
    }

    public static function findById(int $id)
    {
        $conn = Flight::db();
        $stmt = $conn->prepare("SELECT c.*, t.poids AS truie_poids, p.nombre_males, p.nombre_femelles, p.date_naissance 
                               FROM bao_cycle_reproduction c 
                               JOIN bao_truie t ON c.id_truie = t.id_truie 
                               LEFT JOIN bao_portee p ON c.id_cycle_reproduction = p.id_cycle_reproduction 
                               WHERE c.id_cycle_reproduction = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ? CycleModel::fromArray($result) : null;
    }

    public static function create(int $id_truie, string $date_debut_cycle, ?string $date_fin_cycle, ?int $nombre_males, ?int $nombre_femelles, ?int $id_insemination = null, string $etat = 'en cours'): bool
    {
        $conn = Flight::db();
        $stmt = $conn->prepare("INSERT INTO bao_cycle_reproduction (id_truie, date_debut_cycle, date_fin_cycle, nombre_males, nombre_femelles, id_insemination, etat) 
                               VALUES (:id_truie, :date_debut_cycle, :date_fin_cycle, :nombre_males, :nombre_femelles, :id_insemination, :etat)");
        return $stmt->execute([
            ':id_truie' => $id_truie,
            ':date_debut_cycle' => $date_debut_cycle,
            ':date_fin_cycle' => $date_fin_cycle,
            ':nombre_males' => $nombre_males,
            ':nombre_femelles' => $nombre_femelles,
            ':id_insemination' => $id_insemination,
            ':etat' => $etat
        ]);
    }

    public static function getCurrentCycleForTruie(int $truieId): ?int
    {
        $conn = Flight::db();
        $stmt = $conn->prepare("SELECT id_cycle_reproduction FROM bao_cycle_reproduction WHERE id_truie = :id_truie AND etat = 'en cours'");
        $stmt->execute([':id_truie' => $truieId]);
        return $stmt->fetchColumn() ?: null;
    }

    public static function getPrecedentTerminatedCycle(int $truieId): ?CycleModel
    {
        $conn = Flight::db();
        $stmt = $conn->prepare("SELECT * FROM bao_cycle_reproduction WHERE id_truie = :id_truie AND etat = 'termine' ORDER BY date_fin_cycle DESC LIMIT 1");
        $stmt->execute([':id_truie' => $truieId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ? CycleModel::fromArray($result) : null;
    }

    public static function getPrevision(int $truieId, int $currentId): array
    {
        $conn = Flight::db();
        $stmt = $conn->prepare("SELECT AVG((date_fin_cycle - date_debut_cycle)) AS avg_days, AVG(nombre_males + nombre_femelles) AS avg_portee 
                               FROM bao_cycle_reproduction WHERE id_truie = :id_truie AND (nombre_males IS NOT NULL OR nombre_femelles IS NOT NULL) AND id_cycle_reproduction != :current_id");
        $stmt->execute([':id_truie' => $truieId, ':current_id' => $currentId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return [
            'days' => $result['avg_days'] ?: 115,
            'portee' => $result['avg_portee'] ?: 0
        ];
    }

    public static function updateEtat(int $id_cycle_reproduction, string $etat): bool
    {
        $conn = Flight::db();
        $stmt = $conn->prepare("UPDATE bao_cycle_reproduction SET etat = :etat WHERE id_cycle_reproduction = :id_cycle_reproduction");
        return $stmt->execute([':etat' => $etat, ':id_cycle_reproduction' => $id_cycle_reproduction]);
    }

    public static function fromArray(array $data): CycleModel
    {
        return new CycleModel(
            $data['id_cycle_reproduction'] ?? 0,
            $data['id_truie'] ?? 0,
            $data['date_debut_cycle'] ?? null,
            $data['date_fin_cycle'] ?? null,
            $data['nombre_males'] ?? null,
            $data['nombre_femelles'] ?? null,
            $data['id_insemination'] ?? null,
            $data['etat'] ?? 'en cours',
            $data['truie_poids'] ?? null
        );
    }
}