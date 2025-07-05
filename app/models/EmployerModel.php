<?php

namespace app\models;

use Flight;
use vendor\flightphp\core\flight\database;
use PDO;
class EmployerModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getpostes() {
        $query = $this->db->prepare("SELECT id_employe_poste, nom_poste FROM bao_employe_poste");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getemp() {
        $query = $this->db->prepare("SELECT e.id_employe, e.nom_employe, e.prenom_employe, p.nom_poste, e.adresse, e.contact_telephone,
            e.date_recrutement, e.date_retirer, e.statut
            FROM bao_employe e
            LEFT JOIN bao_employe_poste p ON e.id_employe_poste = p.id_employe_poste
            ORDER BY e.id_employe DESC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insert_emp($nom,$prenom,$poste,$adresse,$telephone,$date_recrutement,$statut){
        $sql = "INSERT INTO bao_employe (nom_employe, prenom_employe, id_employe_poste, adresse, contact_telephone, date_recrutement, statut)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
        $query = $this->db->prepare($sql);
        $query->execute([$nom, $prenom, $poste, $adresse, $telephone, $date_recrutement, $statut]);
    }
    public function update($nouveau_statut, $id_emp){
        $sql = "UPDATE bao_employe SET statut = ?, date_retirer = NULL WHERE id_employe = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$nouveau_statut, $id_emp]);
    }
    public function update2($nouveau_statut, $id_emp){
        $sql = "UPDATE bao_employe SET statut = ?, date_retirer = CURRENT_DATE WHERE id_employe = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$nouveau_statut, $id_emp]);
    }
    public function getActifs() {
        $sql="SELECT id_employe, nom_employe, prenom_employe FROM bao_employe WHERE statut = 'actif'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function dejaTraite($date) {
        
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM bao_presence WHERE date_presence = ?");
        $stmt->execute([$date]);
        return $stmt->fetchColumn() > 0;
    }

    public function enregistrer($date, $absents) {
        
        $employes = $this->db->query("SELECT id_employe FROM bao_employe WHERE statut = 'actif'")->fetchAll(PDO::FETCH_COLUMN);

        foreach ($employes as $id) {
            $statut = in_array($id, $absents) ? 'absent' : 'present';
            $stmt = $this->db->prepare("INSERT INTO bao_presence (id_employe, date_presence, statut) VALUES (?, ?, ?)");
            $stmt->execute([$id, $date, $statut]);
        }
    }

    public function getDatesTraitees() {
        
        $sql = "SELECT DISTINCT date_presence FROM bao_presence";
        $rows = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $events = [];
        foreach ($rows as $row) {
            $events[] = [
                'title' => '✔ Traité',
                'start' => $row['date_presence'],
                'color' => '#28a745'
            ];
        }
        return $events;
    }

    //     public function getAllActionReactions() {
    //     $query = $this->db->prepare("SELECT ar.*, 
    //                                 p.nom as produit_nom,
    //                                 c.nom as client_nom,
    //                                 a.Libelle as action_libelle,
    //                                 r.Libelle as reaction_libelle
    //                                 FROM action_reaction ar
    //                                 JOIN produit p ON ar.id_produit = p.id_produit
    //                                 JOIN client c ON ar.id_client = c.id_client
    //                                 JOIN action a ON ar.id_action = a.id_action
    //                                 JOIN reaction r ON ar.id_reaction = r.id_reaction");
    //     $query->execute();
    //     return $query->fetchAll(PDO::FETCH_ASSOC);
    // }

    //     public function getAllVentes() {
    //     $query = $this->db->prepare("SELECT v.*, 
    //                                p.nom as produit_nom,
    //                                c.nom as client_nom
    //                                FROM vente v
    //                                JOIN produit p ON v.id_produit = p.id_produit
    //                                JOIN client c ON v.id_client = c.id_client");
    //     $query->execute();
    //     return $query->fetchAll(PDO::FETCH_ASSOC);
    // }
}
?>