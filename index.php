<?php
require __DIR__ . '/vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as Capsule;


#check https://github.com/vlucas/phpdotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();


//Create database connection
# check https://packagist.org/packages/illuminate/database
$capsule = new Capsule;

$capsule->addConnection([
    'driver' => $_ENV['DB_CONNECTION'],
    'host' =>  $_ENV['DB_HOST'],
    'database' => $_ENV['DB_DATABASE'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);
class ShortUrl extends Illuminate\Database\Eloquent\Model {}


// Capture url in request
$code = $_SERVER['QUERY_STRING'] ?? '#';

// Query database

$shortUrl = ShortUrl::query()->where('shortcode', '=', $code)->get();
//Redirect to  original url
$url = $shortUrl[0]->original_url ?? $_ENV['NOTFOUND_URL'];

header("Location: ".$url);
exit();



