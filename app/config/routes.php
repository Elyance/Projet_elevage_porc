<?php

use app\controllers\EnclosController;
use app\controllers\TypePorcController;
use app\controllers\AlimentController;
use app\controllers\NourrirController;
use app\controllers\ReapproController;

use flight\net\Router;
use flight\Engine;

// use Flight;

/**
 * @var Router $router
 * @var Engine $app
 */

$AlimentController = new AlimentController();
$NourrirController= new NourrirController();
$ReapproController = new ReapproController();

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


Flight::route('/aliments', function() {
    // Aliments
    $router->get('/', [$AlimentController, 'index']);
    $router->post('/@id', [$AlimentController, 'show']);

    // Nourrir
    $router->post('/nourrir', [$NourrirController, 'index']);
    $router->post('/nourrir/action', [$NourrirController, 'nourrir']);

    // Réapprovisionnement
    $router->get('/reappro', [$ReapproController, 'index']);
    $router->post('/reappro/action', [$ReapproController, 'reapprovisionner']);

});
