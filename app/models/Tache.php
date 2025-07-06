<?php
namespace app\models;

use PDO;
use Flight;

class Tache {
    // protected $db;
    public function __construct() {
    }

    // Récupérer toutes les tâches avec le poste concerné
    public function all() {
        $db = Flight::db();
        $sql = "SELECT t.*, p.nom_poste FROM bao_tache t JOIN bao_employe_poste p ON t.id_employe_poste = p.id_employe_poste ORDER BY t.id_tache DESC";
        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer une tâche par id
    public function find($id) {
        $db = Flight::db();
        $stmt = $db->prepare("SELECT * FROM bao_tache WHERE id_tache = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
 
    // Créer une tâche
    public function create($data) {
        $db = Flight::db();
        $stmt = $db->prepare("INSERT INTO bao_tache (id_employe_poste, nom_tache, description) VALUES (?, ?, ?)");
        return $stmt->execute([$data['id_employe_poste'], $data['nom_tache'], $data['description']]);
    }

    // Modifier une tâche
    public function update($id, $data) {
        $db = Flight::db();
        $stmt = $db->prepare("UPDATE bao_tache SET id_employe_poste=?, nom_tache=?, description=? WHERE id_tache=?");
        return $stmt->execute([$data['id_employe_poste'], $data['nom_tache'], $data['description'], $id]);
    }

    // Supprimer une tâche
    public function delete($id) {
        $db = Flight::db();
        $stmt = $db->prepare("DELETE FROM bao_tache WHERE id_tache=?");
        return $stmt->execute([$id]);
    }

    // Récupérer les postes (rôles)
    public function getPostes() {
        $db = Flight::db();
        return $db->query("SELECT * FROM bao_employe_poste")->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les tâches filtrées par poste
    public function getByPoste($id_employe_poste) {
        $db = Flight::db();
        $stmt = $db->prepare("SELECT * FROM bao_tache WHERE id_employe_poste = ?");
        $stmt->execute([$id_employe_poste]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un employé par id
    public function getEmploye($id_employe) {
        $db = Flight::db();
        $stmt = $db->prepare("SELECT * FROM bao_employe WHERE id_employe = ?");
        $stmt->execute([$id_employe]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer tous les employés actifs
    public function getEmployesActifs() {
        $db = Flight::db();
        return $db->query("SELECT * FROM bao_employe WHERE statut = 'actif'")->fetchAll(PDO::FETCH_ASSOC);
    }

    // Assigner une tâche à un employé
    public function assignTache($data) {
        $db = Flight::db();
        $stmt = $db->prepare("INSERT INTO bao_tache_employe (id_tache, id_employe, date_attribution, statut, date_echeance) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['id_tache'],
            $data['id_employe'],
            date('Y-m-d'),
            'non commencer',
            $data['date_echeance']
        ]);
    }

    // Récupérer les tâches assignées à un employé
    public function getTachesEmploye($id_employe) {
        $db = Flight::db();
        $sql = 'SELECT te.*, t.nom_tache FROM bao_tache_employe te JOIN bao_tache t ON te.id_tache = t.id_tache WHERE te.id_employe = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$id_employe]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Marquer des tâches comme accomplies
    public function setTachesDone($ids) {
        $db = Flight::db();
        $stmt = $db->prepare('UPDATE bao_tache_employe SET statut = ? WHERE id_tache_employe = ?');
        foreach ($ids as $id) {
            $stmt->execute(['terminee', $id]);
        }
    }
    public function setTachesDone2($ids,$date) {
        $db = Flight::db();
        $stmt = $db->prepare('UPDATE bao_tache_employe SET statut = ? WHERE id_tache = ? AND date_echeance = ?');
        
        $stmt->execute(['termine', $ids,$date]);
        
    }
}
