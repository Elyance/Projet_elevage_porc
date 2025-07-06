<?php

namespace app\controllers;

use app\models\EnclosModel;
use app\models\EnclosTypeModel;
use Exception;

class EnclosController
{
    public function __construct()
    {
    }

    public function delete($id)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $enclos = EnclosModel::findById($id);
        if ($enclos) {
            EnclosModel::delete($id);
            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => 'Enclos supprimé avec succès',
            ];
        } else {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Enclos non trouvé',
            ];
        }
        \Flight::redirect('/enclos');
    }

    public function deplacer()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (\Flight::request()->method == 'POST') {
            $id_enclos_source = \Flight::request()->data->enclos_source;
            $quantite = \Flight::request()->data->quantite;
            $id_enclos_destination = \Flight::request()->data->enclos_destination;

            if (empty($id_enclos_source) || empty($quantite) || empty($id_enclos_destination)) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Veuillez remplir tous les champs',
                ];
                \Flight::redirect('/enclos/deplacer');
            } else {
                $EnclosSource = EnclosModel::findById($id_enclos_source);
                $EnclosDestination = EnclosModel::findById($id_enclos_destination);

                $new_stockage_source = $EnclosSource['stockage'] - $quantite;

                if ($new_stockage_source <= 0) {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => 'Stockage insuffisant dans l\'enclos source',
                    ];
                    \Flight::redirect('/enclos/deplacer');
                } else {
                    EnclosModel::update($id_enclos_source, $EnclosSource['enclos_type'], $new_stockage_source);
                    $new_stockage_destination = $EnclosDestination['stockage'] + $quantite;
                    EnclosModel::update($id_enclos_destination, $EnclosDestination['enclos_type'], $new_stockage_destination);
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'source : Deplacement effectué avec succès',
                    ];
                    \Flight::redirect('/enclos/deplacer');
                }
            }
        } else {
            $data = ['page' => 'enclos/deplacer', 'enclos' => EnclosModel::getAllTsyArray()];
            \Flight::render('template', $data);
        }
    }

    public function show($id)
    {
        $enclos = EnclosModel::findByIdJoined($id);
        $data = ['page' => 'enclos/show', 'enclos' => $enclos];
        \Flight::render('template', data: $data);
    }

    public static function index()
    {
        $enclos = EnclosModel::getAllTsyArray();
        $data = ['page' => 'enclos/index', 'enclos' => $enclos];
        \Flight::render('template', $data);
    }

    public function create()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (\Flight::request()->method == 'POST') {
            $error = [];
            $type_enclos = \Flight::request()->data->type_enclos;

            if (empty($type_enclos)) {
                $error['type_enclos'] = 'Le type d enclos est obligatoire';
            }

            $stockage = \Flight::request()->data->stockage;
            if (empty($stockage)) {
                $error['stockage'] = 'Le stockage est obligatoire';
            } elseif ($stockage < 1) {
                $error['stockage'] = 'Le doit etre superieur ou égal à 1';
            }

            if (empty($error)) {
                EnclosModel::create($type_enclos, $stockage);
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Enclos créée avec succès',
                ];
                \Flight::redirect('/enclos');
            } else {
                $data = ['page' => 'enclos/form', 'enclos_type' => EnclosTypeModel::getAll()];
                $data['error'] = $error;
                \Flight::render('template', $data);
            }
        } else {
            $data = ['page' => 'enclos/form', 'enclos_type' => EnclosTypeModel::getAll()];
            \Flight::render('template', $data);
        }
    }

    public function listWithPortees()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $enclosData = $this->getEnclosWithPortees();
        $data = ['page' => 'enclos/list_with_portees', 'enclosData' => $enclosData];
        \Flight::render('template', $data);
    }

    private function getEnclosWithPortees()
    {
        $conn = \Flight::db();
        $stmt = $conn->query("
            SELECT 
                e.id_enclos, t.nom_type, e.surface,
                ep.id_enclos_portee, ep.id_portee, ep.quantite_total, ep.poids_estimation, 
                ep.statut_vente, ep.nombre_jour_ecoule,
                p.id_truie, p.id_race, p.nombre_males, p.nombre_femelles, p.date_naissance, p.id_cycle_reproduction
            FROM bao_enclos e
            JOIN bao_type_porc t ON e.enclos_type = t.id_type_porc
            LEFT JOIN bao_enclos_portee ep ON e.id_enclos = ep.id_enclos
            LEFT JOIN bao_portee p ON ep.id_portee = p.id_portee
            ORDER BY e.id_enclos
        ");
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $enclosData = [];
        foreach ($results as $row) {
            $id_enclos = $row['id_enclos'];
            if (!isset($enclosData[$id_enclos])) {
                $enclosData[$id_enclos] = [
                    'id_enclos' => $row['id_enclos'],
                    'nom_type' => $row['nom_type'],
                    'surface' => $row['surface'],
                    'portees' => []
                ];
            }
            if ($row['id_enclos_portee']) {
                $enclosData[$id_enclos]['portees'][] = [
                    'id_enclos_portee' => $row['id_enclos_portee'],
                    'id_portee' => $row['id_portee'],
                    'quantite_total' => $row['quantite_total'],
                    'poids_estimation' => $row['poids_estimation'],
                    'statut_vente' => $row['statut_vente'],
                    'nombre_jour_ecoule' => $row['nombre_jour_ecoule'],
                    'id_truie' => $row['id_truie'],
                    'id_race' => $row['id_race'],
                    'nombre_males' => $row['nombre_males'],
                    'nombre_femelles' => $row['nombre_femelles'],
                    'date_naissance' => $row['date_naissance'],
                    'id_cycle_reproduction' => $row['id_cycle_reproduction']
                ];
            }
        }
        return array_values($enclosData);
    }

    public function movePortee()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (\Flight::request()->method == 'POST') {
            $id_enclos_portee_source = \Flight::request()->data->id_enclos_portee_source;
            $id_enclos_destination = \Flight::request()->data->id_enclos_destination;
            $quantite_males = (int) \Flight::request()->data->quantite_males;
            $quantite_femelles = (int) \Flight::request()->data->quantite_femelles;

            $source = $this->getEnclosPortee($id_enclos_portee_source);
            if (!$source || $source['quantite_total'] < ($quantite_males + $quantite_femelles) || $source['id_portee'] === null) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Quantité insuffisante ou source invalide dans la source'];
                \Flight::redirect('/enclos/move');
                return;
            }

            $destination = $this->getEnclosPorteeByEnclosAndPortee($id_enclos_destination, $source['id_portee']);
            if (!$destination) {
                $destinationId = $this->createEnclosPortee(
                    $id_enclos_destination,
                    $source['id_portee'],
                    $quantite_males + $quantite_femelles,
                    $source['poids_estimation'],
                    $source['nombre_jour_ecoule']
                );
            } else {
                $destinationId = $destination['id_enclos_portee'];
                $newQuantity = ($destination['quantite_total'] ?? 0) + $quantite_males + $quantite_femelles;
                $this->updateEnclosPorteeDetails($destinationId, $newQuantity, $source['poids_estimation'], $source['nombre_jour_ecoule']);
            }

            $this->updateEnclosPorteeQuantite($id_enclos_portee_source, $source['quantite_total'] - ($quantite_males + $quantite_femelles));

            $this->recordMovement($id_enclos_portee_source, $destinationId, $quantite_males, $quantite_femelles);

            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Mouvement effectué avec succès'];
            \Flight::redirect('/enclos/move');
        } else {
            $enclos = EnclosModel::getAllTsyArray();
            $enclosPortees = $this->getAllEnclosPortees();
            $data = ['page' => 'enclos/move', 'enclos' => $enclos, 'enclosPortees' => $enclosPortees];
            \Flight::render('template', $data);
        }
    }

    private function getEnclosPortee($id)
    {
        $conn = \Flight::db();
        $stmt = $conn->prepare("SELECT * FROM bao_enclos_portee WHERE id_enclos_portee = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    private function getAllEnclosPortees()
    {
        $conn = \Flight::db();
        $stmt = $conn->query("
            SELECT ep.id_enclos_portee, e.id_enclos, t.nom_type, p.date_naissance, ep.quantite_total, ep.poids_estimation, ep.nombre_jour_ecoule
            FROM bao_enclos_portee ep
            JOIN bao_enclos e ON ep.id_enclos = e.id_enclos
            LEFT JOIN bao_portee p ON ep.id_portee = p.id_portee
            JOIN bao_type_porc t ON e.enclos_type = t.id_type_porc
        ");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function getEnclosPorteeByEnclosAndPortee($id_enclos, $id_portee)
    {
        $conn = \Flight::db();
        $stmt = $conn->prepare("SELECT * FROM bao_enclos_portee WHERE id_enclos = :id_enclos AND id_portee = :id_portee");
        $stmt->execute([':id_enclos' => $id_enclos, ':id_portee' => $id_portee]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    private function createEnclosPortee($id_enclos, $id_portee, $quantite, $poids, $joursEcoules)
    {
        $conn = \Flight::db();
        $stmt = $conn->prepare("
            INSERT INTO bao_enclos_portee (id_enclos, id_portee, quantite_total, poids_estimation, nombre_jour_ecoule)
            VALUES (:id_enclos    (:id_enclos, :id_portee, :quantite, :poids, :jours_ecoules)
        ");
        $stmt->execute([
            ':id_enclos' => $id_enclos,
            ':id_portee' => $id_portee,
            ':quantite' => $quantite,
            ':poids' => $poids,
            ':jours_ecoules' => $joursEcoules
        ]);
        return $conn->lastInsertId();
    }

    private function updateEnclosPorteeDetails($id, $quantite, $poids, $joursEcoules)
    {
        $conn = \Flight::db();
        $stmt = $conn->prepare("
            UPDATE bao_enclos_portee
            SET quantite_total = :quantite, poids_estimation = :poids, nombre_jour_ecoule = :jours_ecoules
            WHERE id_enclos_portee = :id
        ");
        $stmt->execute([
            ':quantite' => $quantite,
            ':poids' => $poids,
            ':jours_ecoules' => $joursEcoules,
            ':id' => $id
        ]);
    }

    private function updateEnclosPorteeQuantite($id, $quantite)
    {
        $conn = \Flight::db();
        $stmt = $conn->prepare("UPDATE bao_enclos_portee SET quantite_total = :quantite WHERE id_enclos_portee = :id");
        $stmt->execute([':quantite' => $quantite, ':id' => $id]);
    }

    private function recordMovement($sourceId, $destinationId, $males, $femelles)
{
    $conn = \Flight::db();
    $stmt = $conn->prepare("
        INSERT INTO bao_mouvement_enclos_portee 
        (id_enclos_portee_source, id_enclos_portee_destination, quantite_males_deplaces, quantite_femelles_deplaces, date_mouvement)
        VALUES (:source, :destination, :males, :femelles, CURRENT_DATE)
    ");
    $stmt->execute([
        ':source' => $sourceId,
        ':destination' => $destinationId,
        ':males' => $males,
        ':femelles' => $femelles
    ]);
}
    public function convertFemalesToSows()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $eligibleFemales = $this->getEligibleFemales();
        $enclosTrie = $this->getTrieEnclos();

        if (\Flight::request()->method == 'POST') {
            $id_portee = \Flight::request()->data->id_portee;
            $id_enclos = \Flight::request()->data->id_enclos;
            $quantity = (int) \Flight::request()->data->quantity;

            $this->convertToSow($id_portee, $id_enclos, $quantity);

            $_SESSION['flash'] = ['type' => 'success', 'message' => "$quantity femelle(s) convertie(s) en truie(s) et déplacée(s) avec succès"];
            // \Flight::redirect('/enclos/convert-females');
        } else {
            $data = ['page' => 'enclos/convert_females', 'females' => $eligibleFemales, 'enclosTrie' => $enclosTrie];
            \Flight::render('template', $data);
        }
    }

    private function getEligibleFemales()
    {
        $conn = \Flight::db();
        $stmt = $conn->query("
            SELECT p.id_portee, p.date_naissance, p.nombre_femelles, ep.id_enclos_portee, ep.id_enclos, ep.quantite_total, ep.nombre_jour_ecoule, ep.poids_estimation
            FROM bao_portee p
            JOIN bao_enclos_portee ep ON p.id_portee = ep.id_portee
            WHERE ep.nombre_jour_ecoule >= 334
            AND p.nombre_femelles > 0
        ");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function getTrieEnclos()
    {
        $conn = \Flight::db();
        $stmt = $conn->query("
            SELECT id_enclos, nom_type, surface
            FROM bao_enclos e
            JOIN bao_type_porc t ON e.enclos_type = t.id_type_porc
            WHERE t.nom_type = 'Truie'
        ");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    private function convertToSow($id_portee, $id_enclos, $quantity)
    {
        $conn = \Flight::db();
        $conn->beginTransaction();
        echo "eto";
        
        try {
            echo "eto1";
            $sourcePortee = $this->getEnclosPorteeByPortee($id_portee);
            if ($sourcePortee && $sourcePortee['quantite_total'] >= $quantity && $quantity > 0) {
                $maxFemales = $sourcePortee['nombre_femelles'] ?? $sourcePortee['quantite_total'];
                if ($quantity > $maxFemales) {
                    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Quantité demandée dépasse les femelles disponibles.'];
                    \Flight::redirect('/enclos/convert-females');
                    return;
                }
                echo "eto2";
                
                $poids = $sourcePortee['poids_estimation'] ?? 150.000;
                $joursEcoules = $sourcePortee['nombre_jour_ecoule'] ?? 334;

                $destinationPortee = $this->getEnclosPorteeByEnclos($id_enclos);
                // if (!$destinationPortee) {
                    $stmt = $conn->prepare("
                        INSERT INTO bao_enclos_portee (id_enclos, id_portee, quantite_total, poids_estimation, nombre_jour_ecoule, statut_vente)
                        VALUES (:id_enclos, NULL, :quantity, :poids, :jours_ecoules, 'possible')
                        ");
                        $stmt->execute([
                            ':id_enclos' => $id_enclos,
                            ':quantity' => $quantity,
                        ':poids' => $poids,
                        ':jours_ecoules' => $joursEcoules
                    ]);
                    echo "eto3";
                    $destinationId = $conn->lastInsertId();
                    // } else {
                        //     $destinationId = $destinationPortee['id_enclos_portee'];
                        //     $newQuantity = ($destinationPortee['quantite_total'] ?? 0) + $quantity;
                        //     $this->updateEnclosPorteeDetails($destinationId, $newQuantity, $poids, $joursEcoules);
                        // }

                    for ($i = 0; $i < $quantity; $i++) {
                        $stmt = $conn->prepare("
                    INSERT INTO bao_truie (id_enclos, id_race, poids, date_entree)
                    VALUES (:id_enclos, 1, :poids, CURRENT_DATE)
                ");
                    $stmt->execute([
                        ':id_enclos' => $id_enclos,
                        ':poids' => $poids,
                    ]);
                    echo "eto4";
                }
                echo "alalaalala";

                $newSourceQuantity = $sourcePortee['quantite_total'] - $quantity;
                $this->updateEnclosPorteeQuantite($sourcePortee['id_enclos_portee'], $newSourceQuantity > 0 ? $newSourceQuantity : 0);

                $this->recordMovement($sourcePortee['id_enclos_portee'], $destinationId, 0, $quantity);

                $conn->commit();
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Quantité invalide ou insuffisante dans la portée.'];
                \Flight::redirect('/enclos/convert-females');
                // return;
            }
        } catch (Exception $e) {
            echo $e;
            $conn->rollBack();
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Erreur lors de la conversion: ' . $e->getMessage()];
            \Flight::redirect('/enclos/convert-females');
        }
    }

    private function getEnclosPorteeByPortee($id_portee)
    {
        $conn = \Flight::db();
        $stmt = $conn->prepare("
            SELECT ep.*, p.nombre_femelles
            FROM bao_enclos_portee ep
            LEFT JOIN bao_portee p ON ep.id_portee = p.id_portee
            WHERE ep.id_portee = :id_portee
            LIMIT 1
        ");
        $stmt->execute([':id_portee' => $id_portee]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    private function getEnclosPorteeByEnclos($id_enclos)
    {
        $conn = \Flight::db();
        $stmt = $conn->prepare("SELECT * FROM bao_enclos_portee WHERE id_enclos = :id_enclos LIMIT 1");
        $stmt->execute([':id_enclos' => $id_enclos]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}

?>