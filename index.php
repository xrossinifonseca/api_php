<?php
header('Content-Type: application/json');

require_once './models/UserModel.php';
require_once './services/UserService.php';
require_once './controllers/UserController.php';
require_once "./db/conexao.php";


$userModel = new UserModel($conexao);
$userService = new UserService($userModel, $conexao);
$userController = new UserController($userService);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/users') {

    return $userController->createUser();
}
