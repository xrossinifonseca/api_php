<?php

class ClienteController
{
    private $clienteService;

    public function __construct($clienteService)
    {
        $this->clienteService = $clienteService;
    }


    public function createUser()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);

        try {
            $this->clienteService->createUser($requestData);



            $response = [
                "sucesso" => true,
                "message" => 'cliente cadastrado com sucesso.'

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
        } catch (Exception $e) {

            $response = [
                'success' => false,
                'message' => "Erro no servidor"
            ];

            http_response_code(500);
            echo json_encode($response);
        }
    }
}
