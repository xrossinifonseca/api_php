<?php

namespace App\Services;

use App\Validations\ValidationsFilds;
use Exception;

class ClienteService
{
    private $clienteModel;
    public $validation;

    public function __construct($clienteModel)
    {
        $this->clienteModel = $clienteModel;
        $this->validation = new ValidationsFilds();
    }


    public function createUser($request)
    {


        $this->validarDados($request);

        $isEmailRegistered =  $this->clienteModel->isRegistered('cliente', 'email', $request['email']);

        if ($isEmailRegistered) {
            throw new Exception("Email ja cadastrado.");
            exit;
        }

        $senha = $request['senha'];
        if (strlen($senha) < 6) {
            throw new Exception("Senha precisa ter no mínimo 6 caracteres.");
            exit;
        }

        $id = $this->clienteModel->create($request);

        return $id;
    }


    public function getClienteSafety($id)
    {

        if (!$id) {
            throw new Exception("Id inválido.");
            exit;
        }
        $cliente = $this->clienteModel->getCliente($id);

        if (!$cliente) {
            throw new Exception('usuário não localizado.');
            exit;
        }

        return $cliente;
    }

    public function alterarDadosSafety($request, $id)
    {


        $this->validarDados($request);

        $this->clienteModel->alterarDados($request, $id);
    }


    private function validarDados($request)
    {


        $requireFilds = array_keys($request);

        $missFilds = array();

        foreach ($requireFilds as $filds) {
            if (empty($request[$filds])) {

                if ($filds != 'complemento')
                    $missFilds[] = $filds;
            }
        }


        if (!empty($missFilds)) {
            $fildsResponse = implode(', ', $missFilds);
            throw new Exception("Necessário preencher campo " . $fildsResponse);
            exit;
        }


        if ($request['cpf']) {
            $cpf = preg_replace('/[^0-9]/', "", $request['cpf']);
            if (!$this->validation->isCpfValid($cpf)) {
                throw new Exception("CPF inválido.");
                exit;
            }
            $response =  $this->clienteModel->isRegistered('cliente', 'cpf', $cpf);

            if ($response) {
                throw new Exception("CPF ja cadastrado.");
                exit;
            }
        }
    }


    public function alterarSenhaSafety($request, $id)
    {

        $this->validarDados($request);

        $senha_atual = $request['senha_atual'];
        $nova_senha = $request['nova_senha'];


        if (strlen($nova_senha) < 6) {
            throw new Exception("Senha precisa ter no mínimo 6 caracteres.");
            exit;
        }


        $cliente =  $this->clienteModel->isRegistered('cliente', 'id', $id);



        if (!password_verify($senha_atual, $cliente['senha'])) {
            throw new Exception('Senha inválida');
            exit;
        }

        $this->clienteModel->alterarSenha($nova_senha, $id);
    }


    public function verificarCpf($request)
    {

        $this->validarDados($request);
        return false;
    }
}
