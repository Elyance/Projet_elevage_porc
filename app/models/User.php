<?php

namespace app\models;

use Flight;

class User
{
    private int $idUser;
    private string $username;
    private string $password;
    private string $nomrole;
    private int $role;

    public function __construct(int $idUser = 0, string $username = '', string $password = '', string $nomrole = '' , int $role=2)
    {
        $this->idUser = $idUser;
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
        $this->nomrole = $nomrole;
    }

    public function getIdUser(): int {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): void {
        $this->idUser = $idUser;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function setUsername(string $username): void {
        $this->username = $username;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole(int $role): void {
        $this->role = $role;
    }

    public function getNomRole() {
        return $this->nomrole;
    }

    public function setNomRole(string $role): void {
        $this->nomrole = $role;
    }

    public function __toString(): string {
        return "User{idUser={$this->idUser}, username={$this->username}, password={$this->password}, role={$this->role}}";
    }

    function loginUser(string $username, string $password): ?User {
        $sql = "
            SELECT u.id_utilisateur, u.nom_utilisateur, u.mot_de_passe, r.nom_role, r.id_utilisateur_role id_role
            FROM bao_utilisateur u
            JOIN bao_utilisateur_role r ON u.id_utilisateur_role = r.id_utilisateur_role
            WHERE u.nom_utilisateur = :username
            AND u.mot_de_passe = :password
            LIMIT 1
        ";

        $db = Flight::db();
        $stmt = $db->prepare($sql);

        // Utilisation directe de execute avec tableau de paramètres
        $stmt->execute([
            'username' => $username,
            'password' => $password
        ]);

        $row = $stmt->fetch();

        if ($row) {
            return new User(
                (int)$row['id_utilisateur'],
                $row['nom_utilisateur'],
                $row['mot_de_passe'],
                $row['nom_role'],
                $row['id_role'] 
            );
        }
        return null; // identifiants invalides
    }

}
