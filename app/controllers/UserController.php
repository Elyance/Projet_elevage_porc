<?php

namespace app\controllers;
use app\models\User;
use Flight;
use SessionMiddleware;

class UserController {

    public function getFormLogin() {
        SessionMiddleware::startSession();
        if (SessionMiddleware::isLoggedIn()) {
            if($_SESSION['user_role_id'] == 1) {
                Flight::redirect(BASE_URL.'/enclos');
            } else {
                Flight::redirect(BASE_URL.'/employee/landing');
            }
            return;
        }
        Flight::render('login', []);
    }

    public function login() {
        SessionMiddleware::startSession();

        $request = Flight::request();
        $username = $request->data->username;
        $password = $request->data->password;
        
        $userModel = new User();
        $user = $userModel->loginUser($username, $password);
        
        if ($user) {
            $_SESSION['user'] = $user->getUsername();
            $_SESSION['user_id'] = $user->getIdUser() - 1; // Keep -1 if intentional
            $_SESSION['user_role_id'] = $user->getRole();
            if ($_SESSION['user_role_id'] == 1) {
                Flight::redirect(BASE_URL.'/enclos');
            } else {
                Flight::redirect(BASE_URL.'/employee/landing');
            }
        } else {
            Flight::render('login',['message'=> "Veuillez reessayer s'il vous plait"]);
        }
    }

    public function logout() {
        SessionMiddleware::logout();
    }
}