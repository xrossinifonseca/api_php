<?php

namespace App\Controllers;

use App\Models\cliente_token;
use App\Utils\AcessoNegado;
use Exception;

class ClienteController
{
    private $clienteService;
    protected $clienteToken;
    protected $acessoNegado;

    public function __construct($clienteService)
    {
        $this->clienteService = $clienteService;
        $this->clienteToken = new cliente_token();
        $this->acessoNegado = new AcessoNegado();
    }


    public function createCliente()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);

        try {
            $result = $this->clienteService->createUser($requestData);

            $token =   $this->clienteToken->armazenaToken($result);
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

            $token_valid = $this->acessoNegado->verify();
            $id = $token_valid->cliente_id;
            $cliente = $this->clienteService->getClienteSafety($id);

            $response = [
                'success' => true,
                'dados' => $cliente
            ];

            echo json_encode($response);
        } catch (Exception $e) {
            $response = [
                "success" => false,
                "message" => $e->getMessage()
            ];
            if ($e->getMessage() === 'acesso negado') {
                http_response_code(401);
            } else {

                http_response_code(400);
            }

            echo json_encode($response);
        }
    }


    public function alterarDados()
    {
        try {

            $token_valid = $this->acessoNegado->verify();
            $id = $token_valid->cliente_id;

            $requestData = json_decode(file_get_contents("php://input"), true);
            $this->clienteService->alterarDadosSafety($requestData, $id);

            $response = [
                'success' => true,
                'message' => "dados alterado com sucesso!"
            ];

            echo json_encode($response);
        } catch (Exception $e) {
            $response = [
                "success" => false,
                "message" => $e->getMessage()
            ];
            if ($e->getMessage() === 'acesso negado') {
                http_response_code(401);
            } else {

                http_response_code(400);
            }

            echo json_encode($response);
        }
    }

    public function alterarSenha()
    {

        try {

            $token_valid = $this->acessoNegado->verify();
            $id = $token_valid->cliente_id;

            $requestData = json_decode(file_get_contents("php://input"), true);
            $this->clienteService->alterarSenhaSafety($requestData, $id);

            $response = [
                'success' => true,
                'message' => "senha alterada com sucesso!"
            ];

            echo json_encode($response);
        } catch (Exception $e) {
            $response = [
                "success" => false,
                "message" => $e->getMessage()
            ];
            if ($e->getMessage() === 'acesso negado') {
                http_response_code(401);
            } else {

                http_response_code(400);
            }

            echo json_encode($response);
        }
    }


    public function isCpfRegistered()
    {

        try {
            $requestData = json_decode(file_get_contents("php://input"), true);

            $this->clienteService->verificarCpf($requestData);

            $response = [
                "success" => true,
                "isCadastrado" => false
            ];

            echo json_encode($response);
        } catch (Exception $e) {

            if ($e->getMessage() === "CPF ja cadastrado.") {
                $response = [
                    "success" => true,
                    "isCadastrado" => true
                ];
                http_response_code(200);
                echo json_encode($response);
                exit;
            }


            $response = [
                "success" => false,
                "message" => $e->getMessage()
            ];

            http_response_code(400);
            echo json_encode($response);
        }
    }
}
