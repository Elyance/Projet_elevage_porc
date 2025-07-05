<?php

use app\controllers\ApiExampleController;
use app\controllers\TacheController;
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

$Tache_Controller = new TacheController();
$router->get('/taches', [ $Tache_Controller, 'index' ]);
$router->get('/tache/create', [ $Tache_Controller, 'form' ]);
$router->post('/tache/save', [ $Tache_Controller, 'save' ]);
$router->get('/tache/edit/@id', [ $Tache_Controller, 'form' ]);
$router->get('/tache/delete/@id', [ $Tache_Controller, 'delete' ]);
$router->get('/tache/assign', [ $Tache_Controller, 'assignForm' ]);
$router->post('/tache/assign', [ $Tache_Controller, 'assignForm' ]);
$router->post('/tache/assign/save', [ $Tache_Controller, 'assignSave' ]);
$router->get('/taches/employe/@id_employe', [ $Tache_Controller, 'employeTaches' ]);
$router->post('/tache/done', [ $Tache_Controller, 'done' ]);
