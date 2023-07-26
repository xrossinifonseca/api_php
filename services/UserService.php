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
        $requireFilds = array('nome', 'email', 'cpf', 'data_nascimento', 'telefone', 'endereco', 'numero', 'bairro', 'cep', 'cidade', 'estado_id', 'senha');
        $missFilds = array();

        foreach ($requireFilds as $filds) {
            if (empty($request[$filds])) {
                $missFilds[] = $filds;
            }
        }


        if (!empty($missFilds)) {
            $fildsResponse = implode(', ', $missFilds);
            throw new Exception("Necessário preencher campo " . $fildsResponse);
            exit;
        }

        if (!$validation->isCpfValid($request["cpf"])) {
            throw new Exception("CPF inválido.");
            exit;
        }


        $emailUnique = "SELECT * FROM cliente WHERE email = :email";
        $email = $this->conexao->prepare($emailUnique);
        $email->bindParam(':email', $request['email']);
        $email->execute();

        if ($email->rowCount() > 0) {
            throw new Exception('Email ja cadastrado.');
            exit;
        }

        $cpfUnique = "SELECT * FROM cliente WHERE cpf = :cpf";

        $cpf = $this->conexao->prepare($cpfUnique);
        $cpf->bindParam(":cpf", $request['cpf']);
        $cpf->execute();

        if ($cpf->rowCount() > 0) {
            throw new Exception('CPF ja cadastrado.');
            exit;
        }



        $senha = $request['senha'];
        if (strlen($senha) < 6) {
            throw new Exception("Senha precisa ter no mínimo 6 caracteres.");
            exit;
        }


        return  $this->userModel->create($request);
    }
}
