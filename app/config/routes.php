<?php

use app\controllers\ApiExampleController;
use app\controllers\WelcomeController;
use app\controllers\SanteEvenementController;
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
$router->get('/', [ $santeevenementController, 'home' ]); 
$router->get('/evenement', [$santeevenementController, 'findByDate']);
$router->get('/evenement/add', [$santeevenementController, 'formAjouterEvenement']);
$router->post('/evenement/add', [$santeevenementController, 'ajouterEvenement']);
$router->get('/truie', [ $Welcome_Controller, 'truie' ]);
