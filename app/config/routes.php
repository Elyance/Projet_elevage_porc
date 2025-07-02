<?php

use app\controllers\ApiExampleController;
use app\controllers\WelcomeController;
use app\controllers\SimulationEnclosController;
use flight\Engine;
use flight\net\Router;
// use Flight;

/** 
 * @var Router $router 
 * @var Engine $app
 */
/*$router->get('/', function() use ($app) {
	$Welcome_Controller = new WelcomeController($app);
	$app->render('welcome', [ 'message' => 'It works!!' ]);
});*/

$Welcome_Controller = new WelcomeController();
$simul = new SimulationEnclosController();
$router->get('/', [ $Welcome_Controller, 'home' ]); 
$router->get('/truie', [ $Welcome_Controller, 'truie' ]);

$router->get('/simulation/enclos', [ $simul, 'showForm' ]); 
$router->post('/simulation/enclos', [ $simul, 'simulate' ]); 

