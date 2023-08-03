<?php

namespace App\Controllers;

use App\Models\cliente_token;
use App\Utils\AcessoNegado;
use Exception;

class ClienteController
{
    private $clienteService;
    protected $clinete_token;
    protected $acessoNegado;

    public function __construct($clienteService)
    {
        $this->clienteService = $clienteService;
        $this->clinete_token = new cliente_token();
        $this->acessoNegado = new AcessoNegado();
    }


    public function createCliente()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);

        try {
            $result = $this->clienteService->createUser($requestData);

            $token =   $this->clinete_token->armazenaToken($result);
            $response = [
                "sucesso" => true,
                "message" => 'cliente cadastrado com sucesso.',
                "token" => $token

            ];
            http_response_code(201);
            echo json_encode($response);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];

            http_response_code(400);
            echo json_encode($response);
        }
    }

    public function getCliente()
    {
        try {
            if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
                throw new Exception('Acesso negado.');
                exit;
            } else {
                $authorization = $_SERVER['HTTP_AUTHORIZATION'];
                $token = str_replace('Bearer ', '', $authorization);

                $token_valid = $this->acessoNegado->verify($token);

                if (!$token_valid) {
                    throw new Exception('Acesso negado.');
                }

                $id = $token_valid->cliente_id;

                $cliente = $this->clienteService->getClienteSafety($id);

                $response = [
                    'success' => true,
                    'dados' => $cliente
                ];



                echo json_encode($response);
            }
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
