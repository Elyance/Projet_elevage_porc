<?php
namespace app\models;

use PDO;

class ClientModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM bao_client ORDER BY id_client DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM bao_client WHERE id_client = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($nom, $type, $adresse, $telephone, $email) {
        $stmt = $this->db->prepare("INSERT INTO bao_client (nom_client, type_profil, adresse, contact_telephone, contact_email)
                                    VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $type, $adresse, $telephone, $email]);
    }

    public function update($id, $nom, $type, $adresse, $telephone, $email) {
        $stmt = $this->db->prepare("UPDATE bao_client SET nom_client = ?, type_profil = ?, adresse = ?, contact_telephone = ?, contact_email = ?
                                    WHERE id_client = ?");
        $stmt->execute([$nom, $type, $adresse, $telephone, $email, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM bao_client WHERE id_client = ?");
        $stmt->execute([$id]);
    }
}
