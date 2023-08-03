<?php


namespace App\Utils;

use App\Models\cliente_token;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AcessoNegado
{

    private $cliente_token;

    public function __construct()
    {
        $this->cliente_token = new cliente_token();
    }

    public function verify($token)
    {

        $token_valid = $this->cliente_token->verificaToken('token', $token);
        if (!$token_valid) {
            throw new Exception('acesso negado');
            exit;
        }
        $token_decoted = $this->cliente_token->decodificaToken($token);
        return $token_decoted;
    }
}
