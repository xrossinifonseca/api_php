<?php


namespace App\Utils;

use App\Models\cliente_token;
use Exception;


class AcessoNegado
{

    private $cliente_token;

    public function __construct()
    {
        $this->cliente_token = new cliente_token();
    }

    public function verify()
    {

        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            throw new Exception('Acesso negado.');
            exit;
        }

        $authorization = $_SERVER['HTTP_AUTHORIZATION'];
        $token = str_replace('Bearer ', '', $authorization);

        $token_valid = $this->cliente_token->verificaToken('token', $token);
        if (!$token_valid) {
            throw new Exception('acesso negado');
            exit;
        }
        $token_decoted = $this->cliente_token->decodificaToken($token);

        if (!$token_decoted) {
            throw new Exception('Acesso negado.');
        }
        return $token_decoted;
    }
}
