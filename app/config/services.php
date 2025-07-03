<?php

use flight\Engine;
use flight\database\PdoWrapper;
use flight\debug\database\PdoQueryCapture;
use Tracy\Debugger;

use models\AlimentationModel;
use models\NourrirModel;
use models\ReapproModel;
use models\RaceModel;

/** 
 * @var array $config This comes from the returned array at the bottom of the config.php file
 * @var Engine $app
 */

// Configuration PostgreSQL
$dsn = 'pgsql:host=' . $config['database']['host'] . 
       ';port=' . $config['database']['port'] . 
       ';dbname=' . $config['database']['dbname'];

// Déterminez quelle classe PDO utiliser
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