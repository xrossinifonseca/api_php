<?php

class UserController
{
    private $userService;

    public function __construct($userService)
    {
        $this->userService = $userService;
    }


    public function createUser()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);

        try {
            $result =  $this->userService->createUser($requestData);

            if ($result) {
                $response = [
                    "sucesso" => true,
                    "message" => 'usuário cadastrado com sucesso.'

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
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];

            http_response_code(400);
            echo json_encode($response);
        }
    }
}
