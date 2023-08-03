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

        if (!$this->validation->isCpfValid($request["cpf"])) {
            throw new Exception("CPF inválido.");
            exit;
        }

        // verifica se ja existe na tabela

        $this->clienteModel->isRegistered('cliente', 'email', $request['email']);
        $this->clienteModel->isRegistered('cliente', 'cpf', $request['cpf']);


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
}
