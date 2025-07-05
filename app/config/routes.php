<?php

use app\controllers\ApiExampleController;
use app\controllers\UserController;
use app\controllers\WelcomeController;
use app\controllers\EnclosController;
use app\controllers\HomeController;
use app\controllers\ReproductionController;
use app\controllers\CycleController;
use app\controllers\NaissanceController;
use app\controllers\TypePorcController;
use app\controllers\EmployeController;
use app\controllers\SalaireController;
use app\controllers\PresenceController;
use app\controllers\TacheController;
use app\controllers\AddEmployeController;
use app\controllers\AlimentController;
use app\controllers\NourrirController;
use app\controllers\ReapproController;
use app\controllers\SimulationEnclosController;

use flight\net\Router;
use flight\Engine;

/**
 * @var Router $router
 * @var Engine $app
 */
/*$router->get('/', function() use ($app) {
	$Welcome_Controller = new WelcomeController($app);
	$app->render('welcome', [ 'message' => 'It works!!' ]);
});*/

$UserController = new UserController();
$router->get('/',[$UserController, 'getFormLogin']);
$router->post('/login',[$UserController, 'login']);


$Home_Controller = new HomeController();
$router->get("/home", [$Home_Controller, "home"]);

$router->get("/hello-world/@name", function($name) {
    echo "<h1>Hello world! Oh hey " . $name . "!</h1>";
});

$router->group('/typePorc', function () use ($router) {
    $typePorcController = new TypePorcController();
    $router->get('/', [$typePorcController, 'list']);
    $router->get('/add', [$typePorcController, 'form']);
    $router->post('/add', [$typePorcController, 'save']);
    $router->get('/delete', [$typePorcController, 'delete']);
    $router->get('/edit', [$typePorcController, 'form']);
    $router->post('/edit', [$typePorcController, 'update']);
});

$Tache_controller = new TacheController();
$router->get("/taches", [$Tache_controller, "index"]);
$router->get("/tache_peser", [$Tache_controller, "peserPorcs"]);
$router->post("/tache_peser_submit", [$Tache_controller, "submitPesee"]);

$Reproduction_Controller = new ReproductionController();
$router->get("/reproduction", [$Reproduction_Controller, "index"]);
$router->get("/reproduction/inseminate", [$Reproduction_Controller, "inseminate"]);
$router->post("/reproduction/inseminate", [$Reproduction_Controller, "inseminate"]);

$Cycle_Controller = new CycleController();
$router->get("/cycle", [$Cycle_Controller, "index"]);
$router->get("/cycle/add", [$Cycle_Controller, "add"]);
$router->post("/cycle/add", [$Cycle_Controller, "add"]);
$router->get("/cycle/details/@id", [$Cycle_Controller, "details"]);

$Naissance_Controller = new NaissanceController();
$router->get("/naissance/add", [$Naissance_Controller, "add"]);
$router->post("/naissance/add", [$Naissance_Controller, "add"]);

$router->group("/typePorc", function () use ($router) {
    $typePorcController = new TypePorcController();
    $router->get("/", [$typePorcController, "list"]);
    $router->get("/add", [$typePorcController, "form"]);
    $router->post("/add", [$typePorcController, "save"]);
    $router->get("/delete", [$typePorcController, "delete"]);
    $router->get("/edit", [$typePorcController, "form"]);
    $router->post("/edit", [$typePorcController, "update"]);
});

$router->group("/enclos", function () use ($router) {
    $enclosController = new EnclosController();
    $router->get("/", [$enclosController, "list"]);
    $router->get("/add", [$enclosController, "form"]);
    $router->post("/add", [$enclosController, "save"]);
    $router->get("/delete", [$enclosController, "delete"]);
    $router->get("/edit", [$enclosController, "form"]);
    $router->post("/edit", [$enclosController, "update"]);
});

// Employee Routes
$Employe_Controller = new EmployeController();
$router->get("/employe", [$Employe_Controller, "index"]);
$router->get("/employe/congedier/@id", [$Employe_Controller, "congedier"]);

$Salaire_Controller = new SalaireController();
$router->get("/salaire", [$Salaire_Controller, "index"]);
$router->get("/salaire/payer/@id", [$Salaire_Controller, "payer"]);
$router->post("/salaire/payer/@id", [$Salaire_Controller, "payer"]);
$router->get("/salaire/historique_paie", [$Salaire_Controller, "historiquePaie"]);

$Presence_Controller = new PresenceController();
$router->get("/presence", [$Presence_Controller, "index"]);
$router->get("/presence/detail_jour/@date", [$Presence_Controller, "detailJour"]);
$router->get("/presence/add_presence", [$Presence_Controller, "addPresence"]);
$router->post("/presence/add_presence", [$Presence_Controller, "addPresence"]);

$Tache_Controller = new TacheController();
$router->get("/tache", [$Tache_Controller, "index"]);

$AddEmploye_Controller = new AddEmployeController();
$router->get("/add_employe", [$AddEmploye_Controller, "index"]);

$router->group('/aliments', function () use ($router) {
    // Aliments
    $AlimentController = new AlimentController();
    $router->get('/', [$AlimentController, 'index']);
    $router->get('/@id:[0-9]+', [$AlimentController, 'show']);

    // Nourrir
    $router->group('/nourrir', function () use ($router) {
        $NourrirController = new NourrirController();
        $router->get('/', [$NourrirController, 'index']);
        $router->post('/action', [$NourrirController, 'nourrir']);
    });
    

    // Réapprovisionnement
    $ReapproController = new ReapproController();
    $router->get('/reappro', [$ReapproController, 'index']);
    $router->post('/reappro/action', [$ReapproController, 'reapprovisionner']);

});

$simul = new SimulationEnclosController();

$router->get('/simulation', [ $simul, 'index' ]); 
$router->get('/statistique', [ 'app\controllers\StatVenteController', 'index' ]); 


$router->get('/simulation/enclos', [ $simul, 'showForm' ]); 
$router->post('/simulation/enclos', [ $simul, 'simulate' ]); 
Flight::route('GET /simulation/benefice', ['app\controllers\SimulationBeneficeController', 'showForm']);
Flight::route('POST /simulation/benefice', ['app\controllers\SimulationBeneficeController', 'simulate']);


Flight::route('GET /statistiques/aliments', ['app\controllers\StatAlimentController', 'showForm']);
Flight::route('POST /statistiques/aliments', ['app\controllers\StatAlimentController', 'showStats']);
Flight::route('GET /statistiques/ventes', ['app\controllers\StatVenteController', 'showForm']);
Flight::route('POST /statistiques/ventes', ['app\controllers\StatVenteController', 'showStats']);

Flight::route('GET /conge/add', ['app\controllers\CongeController', 'addForm']);
Flight::route('POST /conge/add', ['app\controllers\CongeController', 'add']);

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


Flight::route('GET /taches/employelanding/@id_employe', ['app\controllers\TacheController', 'employeeLanding']);