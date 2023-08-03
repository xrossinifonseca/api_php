<?php


namespace App\Services;

use App\Db\Consulta;
use App\Models\cliente_token;
use Exception;
use Firebase\JWT\JWT;

class Auth
{

    private $consulta;
    private $cliente_token;

    public function __construct()
    {
        $this->consulta = new Consulta();
        $this->cliente_token = new cliente_token();
    }



    public function login($data)
    {
        $cpf = $data['cpf'];
        $senha = $data['senha'];
        $table = 'cliente';
        $coluna = 'cpf';
        $cliente = $this->consulta->SelectWhere($table, $coluna, $cpf);


        if (!$cliente || !password_verify($senha, $cliente['senha'])) {
            throw new Exception('Login ou senha inválidos.');
            exit;
        }
        $id = $cliente['id'];
        $token = $this->cliente_token->armazenaToken($id);
        $response = [
            "sucess" => true,
            "token" => $token
        ];

        return $response;
    }
}
