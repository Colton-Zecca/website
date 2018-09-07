<?php

use App\Kernel;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

require __DIR__.'/../api/vendor/autoload.php';

// The check is to ensure we don't use .env in production
(new Dotenv())->load(__DIR__.'/../api/.env');

$env = empty($_SERVER['APP_ENV']) ? 'dev' : $_SERVER['APP_ENV'];
$debug = (bool) !isset($_SERVER['APP_DEBUG']) ? ('prod' !== $env) : $_SERVER['APP_DEBUG'];

if ($debug) {
    umask(0000);
    Debug::enable();
}

if ($trustedHosts = isset($_SERVER['TRUSTED_HOSTS']) ? $_SERVER['TRUSTED_HOSTS'] : false) {
    Request::setTrustedHosts(explode(',', $trustedHosts));
}

$kernel = new Kernel($env, $debug);
$attributes = array();

if(isset($_SERVER["CONTENT_TYPE"]) && strpos($_SERVER["CONTENT_TYPE"], "application/json") !== false) {
    $_POST = array_merge($_POST, (array) json_decode(trim(file_get_contents('php://input')), true));
}

$request = Request::createFromGlobals();
/** @noinspection PhpUnhandledExceptionInspection */
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
