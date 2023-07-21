<?php



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
            throw new Exception('Necessário preencher todos os campos.');
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







        return  $this->userModel->create($request);
    }
}
