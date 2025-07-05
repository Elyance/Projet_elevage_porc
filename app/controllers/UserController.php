<?php
namespace app\controllers;
use app\models\User; // Ensure this matches your model file
use Flight;

class UserController {
    public function getFormLogin() {
        Flight::render('login', []);
    }

    public function login() {
        $request = Flight::request();
        $username = $request->data->username ?? '';
        $password = $request->data->password ?? '';

        $userModel = new User();
        $user = $userModel->loginUser($username, $password);

        if ($user) {
            if ($user->getRole() == 1) { // Assuming 1 is admin role
                $_SESSION['admin'] = $user;
                Flight::redirect('/home');
            } else {
                $_SESSION['employe'] = $user;
                $userid = $user->getIdUser() - 1; // Keep -1 if intentional
                $queryString = http_build_query(['id_employe' => $userid]);
                Flight::redirect("/taches/employelanding?$queryString");
            }
        } else {
            Flight::render('login', ['message' => "Veuillez réessayer s'il vous plaît"]);
        }
    }
}