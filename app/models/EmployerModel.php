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
    public function insert_emp($nom,$prenom,$poste,$adresse,$telephone,$date_recrutement,$statut){
        $sql = "INSERT INTO bao_employe (nom_employe, prenom_employe, id_employe_poste, adresse, contact_telephone, date_recrutement, statut)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
        $query = $this->db->prepare($sql);
        $query->execute([$nom, $prenom, $poste, $adresse, $telephone, $date_recrutement, $statut]);
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