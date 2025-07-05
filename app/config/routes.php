<?php

use app\controllers\EnclosController;
use flight\Engine;
use flight\net\Router;

// use Flight;

/**
 * @var Router $router
 * @var Engine $app
 */
$enclos_controller = new EnclosController();

$router->get('/enclos', [$enclos_controller, 'index']);
$router->get('/enclos/ajouter', [$enclos_controller, 'create']);
$router->post('/enclos/ajouter', [$enclos_controller, 'create']);
$router->get('/enclos/show/@id', [$enclos_controller, 'show']);
$router->get('/enclos/delete/@id', [$enclos_controller, 'delete']);

$router->get('/enclos/deplacer', [$enclos_controller, 'deplacer']);
$router->post('/enclos/deplacer', [$enclos_controller, 'deplacer']);
