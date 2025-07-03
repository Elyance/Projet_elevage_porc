<?php

use app\controllers\ApiExampleController;
use app\controllers\WelcomeController;

use app\controllers\CommandeController;

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
$router->get('/', [ $Welcome_Controller, 'home' ]); 
$router->get('/truie', [ $Welcome_Controller, 'truie' ]);


$CommandeController = new CommandeController();
$router->post('/commande/add', [$CommandeController, 'add']);
$router->get('/commande/add',[$CommandeController, 'form']);
$router->get('/commande/recette', [$CommandeController, 'recette']);
$router->get('/commande/list', [$CommandeController, 'list']);