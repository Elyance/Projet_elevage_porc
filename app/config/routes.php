<?php

use app\controllers\ApiExampleController;
use app\controllers\UserController;
use app\controllers\EnclosController;
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
use app\controllers\DecesController;
use app\controllers\WelcomeController;
use app\controllers\SanteEvenementController;
use app\controllers\SanteTypeEvenementController;
use app\controllers\DiagnosticController;
use app\controllers\MaladieController;

use flight\Engine;
use flight\net\Router;

/**
 * @var Router $router
 * @var Engine $app
 */
/*$router->get('/', function() use ($app) {
	$Welcome_Controller = new WelcomeController($app);
	$app->render('welcome', [ 'message' => 'It works!!' ]);
});*/



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

// $router->group("/enclos", function () use ($router) {
//     $enclosController = new EnclosController();
//     $router->get("/", [$enclosController, "list"]);
//     $router->get("/add", [$enclosController, "form"]);
//     $router->post("/add", [$enclosController, "save"]);
//     $router->get("/delete", [$enclosController, "delete"]);
//     $router->get("/edit", [$enclosController, "form"]);
//     $router->post("/edit", [$enclosController, "update"]);
// });

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


Flight::route('GET /taches/employelanding', ['app\controllers\TacheController', 'employeeLanding']);

$santeevenementController = new SanteEvenementController();
$santetypeevenementController = new SanteTypeEvenementController();
$diagnosticController = new DiagnosticController();
$maladieController = new MaladieController();
$decesController = new DecesController();

// routes.php or similar configuration file

// Route for listing signalé diagnostics
Flight::route('GET /sante/listDiagnostic', function() {
    Flight::diagnostic()->listDiagnostic();
});
// Route for listing signaled diagnostics
Flight::route('GET /sante/listSignale', function() {
    Flight::diagnostic()->listSignale();
});

// Route for displaying the quarantine selection form
Flight::route('GET /diagnostic/formMoveToQuarantine/@id_diagnostic', function($id_diagnostic) {
    Flight::diagnostic()->formMoveToQuarantine($id_diagnostic);
});

// Route for moving to quarantine (process the selection)
Flight::route('POST /diagnostic/moveToQuarantine/@id_diagnostic', function($id_diagnostic) {
    Flight::diagnostic()->moveToQuarantine($id_diagnostic);
});
// Route for listing quarantine diagnostics
Flight::route('GET /sante/listQuarantine', function() {
    Flight::diagnostic()->listQuarantine();
});

// Route for starting treatment
Flight::route('POST /diagnostic/startTreatment/@id_diagnostic', function($id_diagnostic) {
    Flight::diagnostic()->startTreatment($id_diagnostic);
});

// Route for listing treatment diagnostics
Flight::route('GET /sante/listTreatment', function() {
    Flight::diagnostic()->listTreatment();
});

// Route for marking treatment success
Flight::route('POST /diagnostic/markSuccess/@id_diagnostic', function($id_diagnostic) {
    Flight::diagnostic()->markSuccess($id_diagnostic);
});

// Route for marking treatment failure
Flight::route('POST /diagnostic/markFailure/@id_diagnostic', function($id_diagnostic) {
    Flight::diagnostic()->markFailure($id_diagnostic);
});

// Route for recording death
Flight::route('POST /diagnostic/recordDeath/@id_diagnostic', function($id_diagnostic) {
    Flight::diagnostic()->recordDeath($id_diagnostic);
});

$router->get('/sante', [ $santeevenementController, 'home' ]); 
$router->get('/soin', [ $diagnosticController, 'soin' ]); 

// Map the diagnostic controller
Flight::map('diagnostic', function() {
    return new \app\controllers\DiagnosticController();
});
$router->get('/evenement', [$santeevenementController, 'findByDate']);
$router->get('/evenement/add', [$santeevenementController, 'formAjouterEvenement']);
$router->post('/evenement/add', [$santeevenementController, 'ajouterEvenement']);

$router->get('/typeevenement', [$santetypeevenementController, 'home']);
$router->get('/typeevenement/edit/@id:\d+', [$santetypeevenementController, 'formUpdateTypeEvenement']);
$router->post('/typeevenement/edit/@id:\d+', [$santetypeevenementController, 'UpdateTypeEvenement']);
$router->get('/typeevenement/delete/@id:\d+', [$santetypeevenementController, 'deleteTypeEvenement']);
$router->get('/typeevenement/add', [$santetypeevenementController, 'formAddTypeEvenement']);
$router->post('/typeevenement/add', [$santetypeevenementController, 'addTypeEvenement']);

$router->get('/diagnostic', [ $diagnosticController, 'home' ]); 
$router->get('/diagnostic/add', [$diagnosticController, 'formAddDiagnostic']);
$router->post('/diagnostic/add', [$diagnosticController, 'addDiagnostic']);

$router->get('/maladie', [ $maladieController, 'home' ]); 
$router->get('/maladie/add', [$maladieController, 'formAddMaladie']);
$router->post('/maladie/add', [$maladieController, 'addMaladie']);
$router->get('/maladie/edit/@id:\d+', [$maladieController, 'formUpdateMaladie']);
$router->post('/maladie/edit/@id:\d+', [$maladieController, 'UpdateMaladie']);
$router->get('/maladie/delete/@id:\d+', [$maladieController, 'deleteMaladie']);

$router->get('/deces', [ $decesController, 'home' ]); 
$router->get('/deces/add', [$decesController, 'formAddDeces']);
$router->post('/deces/add', [$decesController, 'addDeces']);
$router->get('/deces/edit/@id:\d+', [$decesController, 'formUpdateDeces']);
$router->post('/deces/edit/@id:\d+', [$decesController, 'UpdateDeces']);
$router->get('/deces/delete/@id:\d+', [$decesController, 'deleteDeces']);

$enclos_controller = new EnclosController();

$router->get('/enclos', [$enclos_controller, 'listWithPortees']);
$router->get('/enclos/move', [$enclos_controller, 'movePortee']);
$router->post('/enclos/move', [$enclos_controller, 'movePortee']);
// $router->get('/enclos/ajouter', [$enclos_controller, 'create']);
// $router->post('/enclos/ajouter', [$enclos_controller, 'create']);
// $router->get('/enclos/show/@id', [$enclos_controller, 'show']);
// $router->get('/enclos/delete/@id', [$enclos_controller, 'delete']);

// $router->get('/enclos/deplacer', [$enclos_controller, 'deplacer']);
// $router->post('/enclos/deplacer', [$enclos_controller, 'deplacer']);
// $router->get('/enclos', [$enclos_controller, 'index']);
Flight::route('/enclos/convert-females', [$enclos_controller, 'convertFemalesToSows']);

$usercontroller = new UserController();
Flight::route('/', [$usercontroller, 'getFormLogin']);
Flight::route('/login', [$usercontroller, 'login']);