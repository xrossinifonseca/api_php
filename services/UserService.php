<?php

require_once "./validations/Validation.php";

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

        $validation = new Validations();

        if (!$request['nome'] || !$request['email'] || !$request["cpf"] || !$request["senha"]) {
            throw new Exception('Necessário preencher todos os campos.');
        }

        if (!$validation->isCpfValid($request["cpf"])) {
            throw new Exception("CPF inválido.");
            exit;
        }


        $emailUnique = "SELECT * FROM users WHERE email = :email";
        $email = $this->conexao->prepare($emailUnique);
        $email->bindParam(':email', $request['email']);
        $email->execute();

        if ($email->rowCount() > 0) {
            throw new Exception('Email ja está em uso.');
            exit;
        }

        $cpfUnique = "SELECT * FROM users WHERE cpf = :cpf";

        $cpf = $this->conexao->prepare($cpfUnique);
        $cpf->bindParam(":cpf", $request['cpf']);
        $cpf->execute();

        if ($cpf->rowCount() > 0) {
            throw new Exception('CPF ja está em uso.');
            exit;
        }



        $senha = $request['senha'];
        if (strlen($senha) < 6) {
            throw new Exception("Senha muito curta");
            exit;
        }


        return  $this->userModel->create($request);
    }
}
