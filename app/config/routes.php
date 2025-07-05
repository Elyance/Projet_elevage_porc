<?php

use app\controllers\ApiExampleController;
use app\controllers\DepartementController;
use app\controllers\WelcomeController;
use app\controllers\DemandeActionController;
use app\controllers\ActionReactionController;
use app\controllers\AgentController;
use app\controllers\CrmController;
use app\controllers\VenteController;
use app\controllers\ClientController;
use app\controllers\TicketController;
use app\controllers\MessageControler;
use app\controllers\EmployerController;
use flight\Engine;
use flight\net\Router;
use app\controllers\ClientControler;

//use Flight;

/** 
 * @var Router $router 
 * @var Engine $app
 */
/*$router->get('/', function() use ($app) {
	$Welcome_Controller = new WelcomeController($app);
	$app->render('welcome', [ 'message' => 'It works!!' ]);
});*/
;


$EmployerController = new EmployerController();
$ClientControler = new ClientControler();

$router->get('/', [ $EmployerController, 'showAcceuil' ]); 
$router->post('/', [ $EmployerController, 'update' ]);
$router->get('/insert', [ $EmployerController, 'show_insert_emp' ]);
$router->post('/insert_emp', [ $EmployerController, 'insert_emp' ]);
$router->post('/changer_statues/@id', [ $EmployerController, 'changer_statues' ]);
Flight::route('GET /presence', [$EmployerController, 'calendrier']);
Flight::route('GET /presence/employes', [$EmployerController, 'getEmployes']);
Flight::route('GET /presence/dates', [$EmployerController, 'getDates']);
Flight::route('POST /presence/save', [$EmployerController, 'enregistrer']);



Flight::route('GET /clients', [$ClientControler, 'index']);
Flight::route('GET /clients/create', [$ClientControler, 'createForm']);
Flight::route('POST /clients/store', [$ClientControler, 'store']);
Flight::route('GET /clients/edit/@id', [$ClientControler, 'editForm']);
Flight::route('POST /clients/update/@id', [$ClientControler, 'update']);
Flight::route('GET /clients/delete/@id', [$ClientControler, 'delete']);
// $router->get('/ventes', [ $vente, 'handleFormVente' ]);
// $router->post('/vente/insert', [ $vente, 'insertVente' ]);
// $router->post('/formulaire', [ $action, 'insertActionReaction' ]);
// $router->get('/showformulaire', [ $CRM, 'handleForm' ]);



//$router->get('/', [ 'WelcomeController', 'home' ]); 

//$router->get('/', \app\controllers\WelcomeController::class.'->home'); 

// $router->get('/hello-world/@name', function($name) {
// 	echo '<h1>Hello world! Oh hey '.$name.'!</h1>';
// });

// $router->group('/api', function() use ($router, $app) {
// 	$Api_Example_Controller = new ApiExampleController($app);
// 	$router->get('/users', [ $Api_Example_Controller, 'getUsers' ]);
// 	$router->get('/users/@id:[0-9]', [ $Api_Example_Controller, 'getUser' ]);
// 	$router->post('/users/@id:[0-9]', [ $Api_Example_Controller, 'updateUser' ]);
// });