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
                Flight::redirect('/home');
            } else {
                $_SESSION['employe'] = $user;
                Flight::render('employeHome', ['message'=> "Bienvenue mon cher employe"]);
            }
        } else {
            Flight::render('login',['message'=> "Veuillez reessayer s'il vous plait"]);
        }
    }
}
