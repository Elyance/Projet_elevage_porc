<?php

use app\controllers\EnclosController;
use app\controllers\TypePorcController;
use flight\net\Router;
use flight\Engine;

// use Flight;

/**
 * @var Router $router
 * @var Engine $app
 */
$router->group('/typePorc', function () use ($router) {
    $typePorcController = new TypePorcController();
    $router->get('/', [$typePorcController, 'list']);
    $router->get('/add', [$typePorcController, 'form']);
    $router->post('/add', [$typePorcController, 'save']);
    $router->get('/delete', [$typePorcController, 'delete']);
    $router->get('/edit', [$typePorcController, 'form']);
    $router->post('/edit', [$typePorcController, 'update']);
});

$router->group('/enclos', function () use ($router) {
    $enclosController = new EnclosController();
    $router->get('/', [$enclosController, 'list']);
    $router->get('/add', [$enclosController, 'form']);
    $router->post('/add', [$enclosController, 'save']);
    $router->get('/delete', [$enclosController, 'delete']);
    $router->get('/edit', [$enclosController, 'form']);
    $router->post('/edit', [$enclosController, 'update']);
});
