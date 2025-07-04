<?php

namespace app\models;

use Flight;

class Depense
{
    public ?string $type_depense;
    public ?string $date_depense;
    public ?float $montant;

    public function __construct(?string $type_depense, ?string $date_depense, ?float $montant)
    {
        $this->type_depense = $type_depense;
        $this->date_depense = $date_depense;
        $this->montant = $montant;
    }

    public static function getAll()
    {
        $conn = Flight::db();
        $sql = 'SELECT type_depense, date_depense, montant FROM bao_view_depenses_totales';
        $result = $conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(fn($item) => self::fromArray($item), $result);
    }

    public static function getFiltered(?string $date_debut = null, ?string $date_fin = null)
    {
        $conn = Flight::db();
        $sql = 'SELECT type_depense, date_depense, montant FROM bao_view_depenses_totales WHERE 1=1';
        $params = [];

        if (!empty($date_debut)) {
            $sql .= ' AND date_depense >= :date_debut';
            $params[':date_debut'] = $date_debut;
        }
        if (!empty($date_fin)) {
            $sql .= ' AND date_depense <= :date_fin';
            $params[':date_fin'] = $date_fin;
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(fn($item) => self::fromArray($item), $result);
    }

    public static function getTotal(?string $date_debut = null, ?string $date_fin = null)
    {
        $conn = Flight::db();
        $sql = 'SELECT SUM(montant) as total FROM bao_view_depenses_totales WHERE 1=1';
        $params = [];

        if (!empty($date_debut)) {
            $sql .= ' AND date_depense >= :date_debut';
            $params[':date_debut'] = $date_debut;
        }
        if (!empty($date_fin)) {
            $sql .= ' AND date_depense <= :date_fin';
            $params[':date_fin'] = $date_fin;
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(\PDO::FETCH_ASSOC)['total'] ?? 0;
    }

    public static function fromArray(array $data): Depense
    {
        return new Depense(
            $data['type_depense'] ?? null,
            $data['date_depense'] ?? null,
            $data['montant'] ?? null
        );
    }
}