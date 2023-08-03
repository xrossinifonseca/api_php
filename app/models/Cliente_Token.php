<?php

namespace App\Models;

use App\Db\Consulta;
use App\Utils\AcessoNegado;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class cliente_token
{

    protected $consulta;

    public function __construct()
    {
        $this->consulta = new Consulta();
    }


    private function gerarToken($id)
    {
        $payload = [
            "exp" => time() + 86400,
            "iat" => time(),
            "cliente_id" => $id
        ];
        $token = JWT::encode($payload, $_ENV['JSON_KEY'], 'HS256');
        return $token;
    }



    public function armazenaToken($id)
    {
        $token = $this->gerarToken($id);
        $response = $this->decodificaToken($token);

        $table = 'cliente_token';
        $data = [
            'cliente_id' => $response->cliente_id,
            'token' => $token,
            'validade' => date('Y-m-d H:i:s', $response->exp)
        ];

        $cliente_id = $response->cliente_id;
        $isCliente = $this->verificaToken('cliente_id', $cliente_id);

        if ($isCliente) {
            $this->removeToken($cliente_id);
        }




        $this->consulta->insertInto($table, $data);

        return $token;
    }


    private function removeToken($id)
    {
        $this->consulta->deleteWhere('cliente_token', 'cliente_id', $id);
    }

    public function verificaToken($coluna, $value)
    {

        $token_valid = $this->consulta->SelectWhere('cliente_token', $coluna, $value);

        return $token_valid;
    }


    public function decodificaToken($token)
    {
        try {

            $decoded = JWT::decode($token, new Key($_ENV['JSON_KEY'], 'HS256'));
            if (!$decoded) {
                throw new Exception("Acesso negado.");
                exit;
            }
            return $decoded;
        } catch (Exception $e) {
            if ($e->getMessage() === 'Expired token') {
                throw new Exception('Acesso negado');
                exit;
            }
        }
    }
}
