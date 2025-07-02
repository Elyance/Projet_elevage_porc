<?php

use app\controllers\ApiExampleController;
use app\controllers\WelcomeController;
use app\controllers\SanteEvenementController;
use app\controllers\SanteTypeEvenementController;
use flight\Engine;
use flight\net\Router;
//use Flight;

/** 
 * @var Router $router 
 * @var Engine $app
 */
/*$router->get('/', function() use ($app) {
	$Welcome_Controller = new WelcomeController($app);
	$app->render('welcome', [ 'message' => 'It works!!' ]);
});*/

$Welcome_Controller = new WelcomeController();
$santeevenementController = new SanteEvenementController();
$santetypeevenementController = new SanteTypeEvenementController();
$router->get('/', [ $santeevenementController, 'home' ]); 
$router->get('/evenement', [$santeevenementController, 'findByDate']);
$router->get('/evenement/add', [$santeevenementController, 'formAjouterEvenement']);
$router->post('/evenement/add', [$santeevenementController, 'ajouterEvenement']);

$router->get('/typeevenement', [$santetypeevenementController, 'home']);
$router->get('/typeevenement/edit/@id:\d+', [$santetypeevenementController, 'formUpdateTypeEvenement']);
$router->post('/typeevenement/edit/@id:\d+', [$santetypeevenementController, 'UpdateTypeEvenement']);
$router->get('/typeevenement/delete/@id:\d+', [$santetypeevenementController, 'deleteTypeEvenement']);
$router->get('/typeevenement/add', [$santetypeevenementController, 'formAddTypeEvenement']);
$router->post('/typeevenement/add', [$santetypeevenementController, 'addTypeEvenement']);

$router->get('/truie', [ $Welcome_Controller, 'truie' ]);
