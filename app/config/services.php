<?php

use flight\Engine;
use flight\database\PdoWrapper;
use flight\debug\database\PdoQueryCapture;
use Tracy\Debugger;

use models\AlimentationModel;
use app\models\NourrirModel;
use app\models\ReapproModel;
use app\models\RaceModel;
use app\models\AlimentModel;


/** 
 * @var array $config This comes from the returned array at the bottom of the config.php file
 * @var Engine $app
 */

// uncomment the following line for MySQL
// $dsn = 'mysql:host=' . $config['database']['host'] . ';dbname=' . $config['database']['dbname'] . ';charset=utf8mb4';

// uncomment the following line for SQLite
// $dsn = 'sqlite:' . $config['database']['file_path'];

$dsn = 'pgsql:host=' . $config['database']['host'] . ';dbname=' . $config['database']['dbname'];


// Uncomment the below lines if you want to add a Flight::db() service
// In development, you'll want the class that captures the queries for you. In production, not so much.
$pdoClass = Debugger::$showBar === true ? PdoQueryCapture::class : PdoWrapper::class;

// Enregistrez le service de base de données avec Flight
Flight::register('db', $pdoClass, [
    $dsn,
    $config['database']['username'],
    $config['database']['password'],
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        // Pour spécifier l'encodage avec PostgreSQL :
        PDO::PGSQL_ATTR_DISABLE_PREPARES => false,
    ]
]);

// Enregistrez vos autres services
Flight::map('aliment', function() {
    return new AlimentModel(Flight::db());
});

Flight::map('nourrir', function() {
    return new NourrirModel(Flight::db());
});

Flight::map('reappro', function() {
    return new ReapproModel(Flight::db());
});

Flight::map('race', function() {
    return new RaceModel(Flight::db());
});