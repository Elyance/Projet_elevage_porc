<?php

class SessionMiddleware {
    
    public static function startSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function requireAuth() {
        self::startSession();
        
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user'])) {
            if($_SESSION['user_role_id'] == 1) {
                Flight::redirect(BASE_URL.'/');
            } else {
                Flight::redirect(BASE_URL.'/employee/landing');
            }
            exit();
        }
    }
    
    public static function isLoggedIn() {
        self::startSession();
        return isset($_SESSION['user_id']) && isset($_SESSION['user']);
    }
    
    public static function getUserId() {
        self::startSession();
        return $_SESSION['user_id'] ?? null;
    }
    
    public static function getUsername() {
        self::startSession();
        return $_SESSION['user'] ?? null;
    }
    
    public static function logout() {
        self::startSession();
        $_SESSION = array();
        session_destroy();
        Flight::redirect(BASE_URL.'/');
    }
}