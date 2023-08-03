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

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


date_default_timezone_set('America/Sao_Paulo');

use App\Controllers\AuthController;
use App\Controllers\ClienteController;
use App\Models\ClienteModel;
use App\Services\Auth;
use App\Services\ClienteService;
use App\Db\Database;


$db = new Database();
$db->connect();





$clienteModel = new ClienteModel();
$clienteService = new ClienteService($clienteModel);
$clienteController = new ClienteController($clienteService);
$auth = new Auth();
$authController = new AuthController($auth);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/registrar') {
    // $requestData = json_decode(file_get_contents("php://input"), true);


    return $clienteController->createCliente();
}




if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/login') {

    // $requestData = json_decode(file_get_contents("php://input"), true);

    return $authController->loginCliente();
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/me') {

    return $clienteController->getCliente();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/') {

    $response = [
        "success" => true,
        "mensagem" => "acesso permitido"

    ];

    http_response_code(200);
    echo json_encode($response);
}
