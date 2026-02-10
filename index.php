<?php
require __DIR__ . '/vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as Capsule;
class ShortUrl extends Illuminate\Database\Eloquent\Model {}

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

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();
// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

// Capture url in request
$code = str_replace('/','',$_SERVER['REQUEST_URI']) ?? '#';

// Query database
$shortUrl = ShortUrl::query()->where('short_code', '=', $code)->first();
//Redirect to  original url

$url = $shortUrl->original_url ?? $_ENV['NOTFOUND_URL'];

header("Location: ".$url);
exit();



