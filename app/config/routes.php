<?php

use app\controllers\ApiExampleController;
use app\controllers\UserController;
use app\controllers\WelcomeController;
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

$UserController = new UserController();
$router->get('/login',[$UserController, 'getFormLogin']);
$router->post('/login',[$UserController, 'login']);
