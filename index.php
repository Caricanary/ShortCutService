<?php
require __DIR__ . '/vendor/autoload.php';

//Create database connection
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'database',
    'username' => 'root',
    'password' => 'password',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);
// Capture url in request


// Query database

//Redirect to  original url