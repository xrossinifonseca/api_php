<?php


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
// header('Access-Control-Max-Age: 86400');
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    exit(0);
}
require 'vendor/autoload.php';
date_default_timezone_set('America/Sao_Paulo');


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();




use App\Db\Database;
use App\Router\Router;

$db = new Database();
$db->connect();

$router = new Router();
$router->chamarRotas();
