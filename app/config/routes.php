<?php

use app\controllers\EnclosController;
use app\controllers\HomeController;
use app\controllers\ReproductionController;
use app\controllers\CycleController;
use app\controllers\NaissanceController;
use app\controllers\TypePorcController;
use flight\net\Router;
use flight\Engine;

/**
 * @var Router $router
 * @var Engine $app
 */

$Home_Controller = new HomeController();
$router->get('/', [$Home_Controller, 'home']);

$router->get('/hello-world/@name', function($name) {
    echo '<h1>Hello world! Oh hey ' . $name . '!</h1>';
});

$Reproduction_Controller = new ReproductionController();
$router->get('/reproduction', [$Reproduction_Controller, 'index']);
$router->get('/reproduction/inseminate', [$Reproduction_Controller, 'inseminate']);
$router->post('/reproduction/inseminate', [$Reproduction_Controller, 'inseminate']);

$Cycle_Controller = new CycleController();
$router->get('/cycle', [$Cycle_Controller, 'index']);
$router->get('/cycle/add', [$Cycle_Controller, 'add']);
$router->post('/cycle/add', [$Cycle_Controller, 'add']);
$router->get('/cycle/details/@id', [$Cycle_Controller, 'details']);

$Naissance_Controller = new NaissanceController();
$router->get('/naissance/add', [$Naissance_Controller, 'add']);
$router->post('/naissance/add', [$Naissance_Controller, 'add']);

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