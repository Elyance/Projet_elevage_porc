<?php
namespace app\models;

use Flight;

class RaceModel
{
    public int $id_race;
    public string $nom_race;
    public ?string $description;
    public ?string $besoins_nutritionnels;
    public ?int $duree_engraissement_jours;

    public function __construct(int $id_race, string $nom_race, ?string $description = null, ?string $besoins_nutritionnels = null, ?int $duree_engraissement_jours = null)
    {
        $this->id_race = $id_race;
        $this->nom_race = $nom_race;
        $this->description = $description;
        $this->besoins_nutritionnels = $besoins_nutritionnels;
        $this->duree_engraissement_jours = $duree_engraissement_jours;
    }

    /**
     * Fetch all breeds from the races_porcs table.
     *
     * @return array Array of RaceModel objects
     */
    public static function getAll()
    {
        $conn = Flight::db();
        $stmt = $conn->query("SELECT * FROM races_porcs");
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(fn($item) => RaceModel::fromArray($item), $result);
    }

    /**
     * Fetch a breed by its ID.
     *
     * @param int $id The ID of the breed
     * @return RaceModel|null The breed object or null if not found
     */
    public static function findById(int $id)
    {
        $conn = Flight::db();
        $stmt = $conn->prepare("SELECT * FROM races_porcs WHERE id_race = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ? RaceModel::fromArray($result) : null;
    }

    /**
     * Create a new breed in the races_porcs table.
     *
     * @param string $nom_race The breed name
     * @param string|null $description The breed description
     * @param string|null $besoins_nutritionnels Nutritional needs
     * @param int|null $duree_engraissement_jours Fattening duration in days
     * @return bool Success of the operation
     */
    public static function create(string $nom_race, ?string $description = null, ?string $besoins_nutritionnels = null, ?int $duree_engraissement_jours = null): bool
    {
        $conn = Flight::db();
        $stmt = $conn->prepare("INSERT INTO races_porcs (nom_race, description, besoins_nutritionnels, duree_engraissement_jours) VALUES (:nom_race, :description, :besoins_nutritionnels, :duree_engraissement_jours)");
        return $stmt->execute([
            ':nom_race' => $nom_race,
            ':description' => $description,
            ':besoins_nutritionnels' => $besoins_nutritionnels,
            ':duree_engraissement_jours' => $duree_engraissement_jours
        ]);
    }

    /**
     * Update an existing breed in the races_porcs table.
     *
     * @param int $id The ID of the breed to update
     * @param string $nom_race The new breed name
     * @param string|null $description The new breed description
     * @param string|null $besoins_nutritionnels The new nutritional needs
     * @param int|null $duree_engraissement_jours The new fattening duration
     * @return bool Success of the operation
     */
    public static function update(int $id, string $nom_race, ?string $description = null, ?string $besoins_nutritionnels = null, ?int $duree_engraissement_jours = null): bool
    {
        $conn = Flight::db();
        $stmt = $conn->prepare("UPDATE races_porcs SET nom_race = :nom_race, description = :description, besoins_nutritionnels = :besoins_nutritionnels, duree_engraissement_jours = :duree_engraissement_jours WHERE id_race = :id");
        return $stmt->execute([
            ':id' => $id,
            ':nom_race' => $nom_race,
            ':description' => $description,
            ':besoins_nutritionnels' => $besoins_nutritionnels,
            ':duree_engraissement_jours' => $duree_engraissement_jours
        ]);
    }

    /**
     * Delete a breed from the races_porcs table.
     *
     * @param int $id The ID of the breed to delete
     * @return bool Success of the operation
     */
    public static function delete(int $id): bool
    {
        $conn = Flight::db();
        $stmt = $conn->prepare("DELETE FROM races_porcs WHERE id_race = :id");
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Create a RaceModel object from an array of data.
     *
     * @param array $data The data array
     * @return RaceModel The constructed object
     */
    public static function fromArray(array $data): RaceModel
    {
        return new RaceModel(
            $data['id_race'] ?? 0,
            $data['nom_race'] ?? '',
            $data['description'] ?? null,
            $data['besoins_nutritionnels'] ?? null,
            $data['duree_engraissement_jours'] ?? null
        );
    }
}