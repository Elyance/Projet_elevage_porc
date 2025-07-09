<?php

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
use app\controllers\DecesController;
use app\controllers\SanteEvenementController;
use app\controllers\SanteTypeEvenementController;
use app\controllers\DiagnosticController;
use app\controllers\MaladieController;
use app\controllers\SimulationEnclosController;
use app\controllers\SimulationBeneficeController;
use app\controllers\StatAlimentController;
use app\controllers\StatVenteController;
use app\controllers\CongeController;
use app\controllers\BudgetController;
use app\controllers\CommandeController;
use app\controllers\DepenseController;

use flight\Engine;
use flight\net\Router;

/**
 * @var Router $router
 * @var Engine $app
*/

//?======= Our controllers
//*--- User
$usercontroller = new UserController();

//*--- Porcs - Enclos
$typePorcController = new TypePorcController();
$enclos_controller = new EnclosController();

//*--- Employe
$Employe_Controller = new EmployeController();
$AddEmploye_Controller = new AddEmployeController();
$Salaire_Controller = new SalaireController();
$Presence_Controller = new PresenceController();

//*--- Aliment
$AlimentController = new AlimentController();
$NourrirController = new NourrirController();
$ReapproController = new ReapproController();

//*--- Tache
$Tache_Controller = new TacheController();

//*--- Simulation
$simul = new SimulationEnclosController();
$simulationBeneficeController = new SimulationBeneficeController();
$statAlimentController = new StatAlimentController();
$statVenteController = new StatVenteController();
$congeController = new CongeController();

//*--- Reprod
$Reproduction_Controller = new ReproductionController();
$Cycle_Controller = new CycleController();
$Naissance_Controller = new NaissanceController();

//*--- Health
$santeevenementController = new SanteEvenementController();
$santetypeevenementController = new SanteTypeEvenementController();
$diagnosticController = new DiagnosticController();
$maladieController = new MaladieController();
$decesController = new DecesController();

// *--- Budget/Commande
$CommandeController = new CommandeController();
$DepenseController = new DepenseController();
$BudgetController = new BudgetController();

//?======= User Routes
Flight::route('/', [$usercontroller, 'getFormLogin']);
Flight::route('/login', [$usercontroller, 'login']);
Flight::route('/logout', [$usercontroller, 'logout']);

//?======= Type Porc routes
$router->group('/typePorc', function () use ($router, $typePorcController) {
    $router->get('/', [$typePorcController, 'list']);
    $router->get('/add', [$typePorcController, 'form']);
    $router->post('/add', [$typePorcController, 'save']);
    $router->get('/delete', [$typePorcController, 'delete']);
    $router->get('/edit', [$typePorcController, 'form']);
    $router->post('/edit', [$typePorcController, 'update']);
});

//?======= Enclos routes
$router->get('/enclos', [$enclos_controller, 'listWithPortees']);
$router->get('/enclos/move', [$enclos_controller, 'movePortee']);
$router->post('/enclos/move', [$enclos_controller, 'movePortee']);
Flight::route('/enclos/convert-females', [$enclos_controller, 'convertFemalesToSows']);

//?======= Food Management Routes
$router->group('/aliments', function () use ($router, $AlimentController, $NourrirController, $ReapproController) {
    //*--- Food list
    $router->get('/', [$AlimentController, 'index']);
    $router->get('/@id:[0-9]+', [$AlimentController, 'show']);
    //*--- Give Food
    $router->group('/nourrir', function () use ($router, $NourrirController) {
        $router->get('/', [$NourrirController, 'index']);
        $router->post('/action', [$NourrirController, 'nourrir']);
    });
    //*--- Replenish Food
    $router->get('/reappro', [$ReapproController, 'index']);
    $router->post('/reappro/action', [$ReapproController, 'reapprovisionner']);
});


//?======= Reproduction-Cycles-Birth management routes
//*--- Reproduction
$router->get("/reproduction", [$Reproduction_Controller, "index"]);
$router->get("/reproduction/inseminate", [$Reproduction_Controller, "inseminate"]);
$router->post("/reproduction/inseminate", [$Reproduction_Controller, "inseminate"]);
//*--- Cycle
$router->get("/cycle", [$Cycle_Controller, "index"]);
$router->get("/cycle/add", [$Cycle_Controller, "add"]);
$router->post("/cycle/add", [$Cycle_Controller, "add"]);
$router->get("/cycle/details/@id", [$Cycle_Controller, "details"]);
//*--- Birth
$router->get("/naissance/add", [$Naissance_Controller, "add"]);
$router->post("/naissance/add", [$Naissance_Controller, "add"]);


//?======= Employee congedier-salaire-presence Management Routes
//*--- Gestion emp
$router->get("/employe", [$Employe_Controller, "index"]);
$router->get("/employe/congedier/@id", [$Employe_Controller, "congedier"]);
$router->get("/add_employe", [$AddEmploye_Controller, "index"]);
$router->post("/add_employe", [$AddEmploye_Controller, "add"]);
//*--- Salaire
$router->get("/salaire", [$Salaire_Controller, "index"]);
$router->get("/salaire/payer/@id", [$Salaire_Controller, "payer"]);
$router->post("/salaire/payer/@id", [$Salaire_Controller, "payer"]);
$router->get("/salaire/historique_paie", [$Salaire_Controller, "historiquePaie"]);
//*--- Presence
$router->get("/presence", [$Presence_Controller, "index"]);
$router->get("/presence/detail_jour/@date", [$Presence_Controller, "detailJour"]);
$router->get("/presence/add_presence", [$Presence_Controller, "addPresence"]);
$router->post("/presence/add_presence", [$Presence_Controller, "addPresence"]);


//?======= Task management routes
//*--- Admin Side
$router->get("/tache", [$Tache_Controller, "index"]);
$router->get('/tache/create', [ $Tache_Controller, 'form' ]);
$router->post('/tache/save', [ $Tache_Controller, 'save' ]);
$router->get('/tache/edit/@id', [ $Tache_Controller, 'form' ]);
$router->get('/tache/delete/@id', [ $Tache_Controller, 'delete' ]);
$router->get('/tache/assign', [ $Tache_Controller, 'assignForm' ]);
$router->post('/tache/assign', [ $Tache_Controller, 'assignForm' ]);
$router->post('/tache/assign/save', [ $Tache_Controller, 'assignSave' ]);
$router->get('/taches/employe/@id_employe', [ $Tache_Controller, 'employeTaches' ]);
Flight::route('/check_tache/@id/@date', [$Tache_Controller, 'getTacheById']);
//*--- Emp Side
$router->get('/employee/landing', [$Tache_Controller, 'employeeLanding']);
$router->post('/tache/done', [ $Tache_Controller, 'done']);
$router->get("/tache_peser", [$Tache_Controller, "peserPorcs"]);
$router->post("/tache_peser_submit", [$Tache_Controller, "submitPesee"]);


//?======= Simulations-Stats Routes
$router->get('/simulation', [ $simul, 'index' ]); 
$router->get('/simulation/enclos', [ $simul, 'showForm' ]); 
$router->post('/simulation/enclos', [ $simul, 'simulate' ]); 
Flight::route('GET /simulation/benefice', [$simulationBeneficeController, 'showForm']);
Flight::route('POST /simulation/benefice', [$simulationBeneficeController, 'simulate']);

//?======= Statistics Routes
$router->get('/statistique', [$statVenteController, 'index' ]); 
Flight::route('GET /statistiques/ventes', [$statVenteController, 'showForm']);
Flight::route('POST /statistiques/ventes', [$statVenteController, 'showStats']);
Flight::route('GET /statistiques/aliments', [$statAlimentController, 'showForm']);
Flight::route('POST /statistiques/aliments', [$statAlimentController, 'showStats']);

//?======= Conge Management Routes
Flight::route('GET /conge/add', [$congeController, 'addForm']);
Flight::route('POST /conge/add', [$congeController, 'add']);


//?======= Health-Diagnostic-Death Management Routes
//*--- Health Events
$router->get('/sante', [ $santeevenementController, 'home' ]);
$router->get('/evenement', [$santeevenementController, 'findByDate']);
$router->get('/evenement/add', [$santeevenementController, 'formAjouterEvenement']);
$router->post('/evenement/add', [$santeevenementController, 'ajouterEvenement']);
//*--- Health Event Types
$router->get('/typeevenement', [$santetypeevenementController, 'home']);
$router->get('/typeevenement/edit/@id:\d+', [$santetypeevenementController, 'formUpdateTypeEvenement']);
$router->post('/typeevenement/edit/@id:\d+', [$santetypeevenementController, 'UpdateTypeEvenement']);
$router->get('/typeevenement/delete/@id:\d+', [$santetypeevenementController, 'deleteTypeEvenement']);
$router->get('/typeevenement/add', [$santetypeevenementController, 'formAddTypeEvenement']);
$router->post('/typeevenement/add', [$santetypeevenementController, 'addTypeEvenement']);
//*--- Diagnostic
$router->get('/diagnostic', [ $diagnosticController, 'home' ]); 
$router->get('/diagnostic/add', [$diagnosticController, 'formAddDiagnostic']);
$router->post('/diagnostic/add', [$diagnosticController, 'addDiagnostic']);
$router->get('/soin', [ $diagnosticController, 'soin' ]);
Flight::route('GET /sante/listDiagnostic', [$diagnosticController, 'listDiagnostic']); //list all diagnostics for page listDiagnostic
Flight::route('GET /sante/listSignale', [$diagnosticController, 'listSignale']); //list all diagnostics for page listSignale
Flight::route('GET /sante/listQuarantine', [$diagnosticController, 'listQuarantine']); //list quarantine diagnostics
Flight::route('GET /sante/listTreatment', [$diagnosticController, 'listTreatment']); //list treatment
Flight::route('POST /diagnostic/startTreatment/@id_diagnostic', [$diagnosticController, 'startTreatment']); //start treatment
Flight::route('POST /diagnostic/markFailure/@id_diagnostic', [$diagnosticController, 'markFailure']); //mark treatement as failure
Flight::route('GET|POST /diagnostic/markSuccess/@id_diagnostic', [$diagnosticController, 'markSuccess']); //mark treatement as success
Flight::route('GET /diagnostic/formMoveToQuarantine/@id_diagnostic', [$diagnosticController, 'formMoveToQuarantine']); //form move to quarantine
Flight::route('POST /diagnostic/moveToQuarantine/@id_diagnostic', [$diagnosticController, 'moveToQuarantine']); //process move to quarantine
Flight::route('POST /diagnostic/recordDeath/@id_diagnostic', [$diagnosticController, 'recordDeath']); //recording death
//*--- Illness
$router->get('/maladie', [ $maladieController, 'home' ]); 
$router->get('/maladie/add', [$maladieController, 'formAddMaladie']);
$router->post('/maladie/add', [$maladieController, 'addMaladie']);
$router->get('/maladie/edit/@id:\d+', [$maladieController, 'formUpdateMaladie']);
$router->post('/maladie/edit/@id:\d+', [$maladieController, 'UpdateMaladie']);
$router->get('/maladie/delete/@id:\d+', [$maladieController, 'deleteMaladie']);
// *--- Deaths
$router->get('/deces', [ $decesController, 'home' ]); 
$router->get('/deces/add', [$decesController, 'formAddDeces']);
$router->post('/deces/add', [$decesController, 'addDeces']);
$router->get('/deces/edit/@id:\d+', [$decesController, 'formUpdateDeces']);
$router->post('/deces/edit/@id:\d+', [$decesController, 'UpdateDeces']);
$router->get('/deces/delete/@id:\d+', [$decesController, 'deleteDeces']);


// *--- Commandes
$router->post('/commande/add', [$CommandeController, 'add']);
$router->get('/commande/add',[$CommandeController, 'form']);
$router->get('/commande/recette', [$CommandeController, 'recette']);
$router->get('/commande/list', [$CommandeController, 'list']);	
$router->get('/commande/edit-status/@id', [$CommandeController, 'editStatus']);
$router->post('/commande/edit-status/@id', [$CommandeController, 'updateStatus']);

// *--- Depenses
$router->get('/depense/list', [$DepenseController, 'list']);


// *--- Budget
$router->get('/budget/index', [$BudgetController, 'index']);
