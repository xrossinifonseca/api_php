<?php


namespace App\Controllers;

use App\Utils\AcessoNegado;
use Exception;

class CompraController
{


    private $clienteService;
    private $acessoNegado;

    public function __construct($clienteService)
    {

        $this->clienteService = $clienteService;
        $this->acessoNegado = new AcessoNegado();
    }



    public function cadastrarCompra()
    {

        try {
            $request = json_decode(file_get_contents("php://input"), true);

            $token_valid = $this->acessoNegado->verify();

            $id = $token_valid->cliente_id;

            $data = [
                'numero' => $request['numero'],
                'valor' => $request['valor'],
                'cliente_id' => $id
            ];

            $this->clienteService->cadastrarCompraSafety($data);

            $response = [
                'success' => true,
                'message' => 'Compra cadastrada com sucesso.'
            ];

            echo json_encode($response);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                "message" => $e->getMessage()
            ];

            if ($e->getMessage() === 'Acesso negado') {
                http_response_code(401);
            } else {

                http_response_code(400);
            }

            echo json_encode($response);
        }
    }
}
