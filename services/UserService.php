<?php

require_once './models/UserModel.php';


class UserService
{
    private $userModel;
    private $conexao;

    public function __construct($userModel, $conexao)
    {
        $this->userModel = $userModel;
        $this->conexao = $conexao;
    }


    public function createUser($request)
    {
        if (!$request['nome'] || !$request['email'] || !$request["cpf"] || !$request["senha"]) {
            $response = [
                'status' => 'error',
                'message' => 'Necessário preencher todos os campos.'
            ];
            http_response_code(400);
            echo json_encode($response);
            exit;
        }

        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':email', $request['email']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $response = [
                'status' => 'error',
                'message' => 'O email já está cadastrado.'
            ];
            http_response_code(400);
            echo json_encode($response);
            exit;
        }


        return  $this->userModel->create($request);
    }
}
