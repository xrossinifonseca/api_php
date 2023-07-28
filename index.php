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


require_once "./models/ClienteModel.php";
require_once './services/ClienteService.php';
require_once './controllers/ClienteController.php';
require_once "./db/conexao.php";


$clienteModel = new ClienteModel($conexao);
$clienteService = new ClienteService($clienteModel, $conexao);
$userController = new ClienteController($clienteService);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/users') {

    return $userController->createUser();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/') {

    $response = [
        "success" => true,
        "mensagem" => "acesso permitido"

    ];

    http_response_code(200);
    echo json_encode($response);
}
