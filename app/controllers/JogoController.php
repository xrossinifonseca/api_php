<?php

namespace App\Controllers;

use App\Utils\AcessoNegado;
use Exception;

class JogoController
{

    private $acessoNegado;
    private $jogoService;


    public function __construct($jogoService)
    {
        $this->acessoNegado = new AcessoNegado();
        $this->jogoService = $jogoService;
    }


    public function quantidadeJogo()
    {
        try {
            $token_valid = $this->acessoNegado->verify();

            $cliente_id = $token_valid->cliente_id;

            $quantidade =   $this->jogoService->quantidadeJogoValidado($cliente_id);

            $response = [
                'success' => true,
                'quantidade' => $quantidade
            ];

            echo json_encode($response);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                "message" => $e->getMessage()
            ];

            if ($e->getMessage() === 'acesso negado') {
                http_response_code(401);
            } else {

                http_response_code(400);
            }

            echo json_encode($response);
        }
    }
}
