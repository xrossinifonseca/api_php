<?php
header('Content-Type: application/json');

require_once './models/UserModel.php';
require_once './services/UserService.php';
require_once "./db/conexao.php";

$userModel = new UserModel($conexao);
$userService = new UserService($userModel, $conexao);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/users') {

    $requestData = json_decode(file_get_contents("php://input"), true);





    try {

        $result = $userService->createUser($requestData);

        if ($result) {
            $response = [
                "status" => "success",

            ];
            echo json_encode($response);
        } else {
            $response = [
                'status' => false,
                'message' => 'Erro ao cadastrar usuário.'
            ];
            http_response_code(400);
            echo  json_encode($response);
        }
    } catch (PDOException $e) {
        echo "ERRO " . $e->getMessage();
    }
}
