<?php

namespace app\controllers;
use app\models\User;
use Flight;

class UserController {
    public function getFormLogin() {
        Flight::render('login', []);
    }

    public function login() {
        $request = Flight::request();
        $username = $request->data->username;
        $password = $request->data->password;

        $userModel = new User();
        $user = $userModel->loginUser($username, $password);

        if ($user) {
            if ($user->getRole() == 1) {

                $_SESSION['admin'] = $user;
                $data = [
                    'title' => 'Gestion Porc - Accueil',
                    'admin' => $_SESSION['admin'],
                    'page' => 'home',
                    'links' => [
                        'Reproduction' => Flight::get('flight.base_url').'/reproduction',
                        'Alimentation' => Flight::get('flight.base_url').'/aliments',
                        'Enclos' => Flight::get('flight.base_url').'/enclos',
                        'Employés' => Flight::get('flight.base_url').'/employe',
                        'Simulation' => Flight::get('flight.base_url').'/simulation',
                        'Statistique' => Flight::get('flight.base_url').'/statistique'
                    ]
                ];
                Flight::render('home', $data);
            } else {
                $_SESSION['employe'] = $user;
                $userid = $user->getIdUser() - 1; // Keep -1 if intentional
                $_SESSION['employeid'] = $userid;
                Flight::render('tache/employee_redirect', ["userid"=>$userid]);
            }
        } else {
            Flight::render('login',['message'=> "Veuillez reessayer s'il vous plait"]);
        }
    }
}