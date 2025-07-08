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
            session_start();
            $_SESSION['user'] = $user->getUsername();
            $_SESSION['user_id'] = $user->getIdUser() - 1; // Keep -1 if intentional
            if ($user->getRole() == 1) {
                Flight::render('home', $data);
            } else {
                Flight::render('tache/employee_redirect', []);
            }
        } else {
            Flight::render('login',['message'=> "Veuillez reessayer s'il vous plait"]);
        }
    }
}