<?php


namespace App\Controllers;

use Exception;

class AuthController
{

    private $auth;

    public function __construct($auth)
    {
        $this->auth = $auth;
    }

    public function loginCliente()
    {
        try {

            $requestData = json_decode(file_get_contents("php://input"), true);

            $result = $this->auth->login($requestData);

            echo json_encode($result);
        } catch (Exception $e) {
            $response = [
                "success" => false,
                "message" => $e->getMessage()
            ];

            http_response_code(400);

            echo json_encode($response);
        }
    }
}
