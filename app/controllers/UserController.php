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
                    'links' => [
                        'Accueil' => Flight::get('flight.base_url').'/login',
                        // 'Taches' => Flight::get('flight.base_url').'/taches',
                        'Reproduction' => Flight::get('flight.base_url').'/reproduction',
                        'Alimentation' => Flight::get('flight.base_url').'/alimentation',
                        'Animaux' => Flight::get('flight.base_url').'/animaux',
                        'Enclos' => Flight::get('flight.base_url').'/enclos',
                        'Employés' => Flight::get('flight.base_url').'/employe',
                        'Affichages' => Flight::get('flight.base_url').'/affichages'
                    ]
                ];
                Flight::render('home', $data);
            } else {
                $_SESSION['employe'] = $user;
                Flight::render('employeHome', ['message'=> "Bienvenue mon cher employe"]);
            }
        } else {
            Flight::render('login',['message'=> "Veuillez reessayer s'il vous plait"]);
        }
    }
}
