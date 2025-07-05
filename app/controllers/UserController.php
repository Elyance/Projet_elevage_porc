<?php

namespace app\controllers;
use app\models\User;
use Flight;

class UserController {
    public function getFormLogin() {
        Flight::render('login', []);
    }

    public function login()
    {
        $request = Flight::request();
        $username = $request->data->username;
        $password = $request->data->password;

        $userModel = new User();
        $user = $userModel->loginUser($username, $password);

        if ($user) {
            if ($user->getRole() == "admin") {
                Flight::render('welcome', ['message' => "Bienvenue admin"]);
            } else {
                Flight::render('welcome', ['message' => "Bienvenue employe"]);
            }
        } else {
            Flight::render('login',['message'=> "Veuillez reessayer s'il vous plait"]);
        }
    }
}
