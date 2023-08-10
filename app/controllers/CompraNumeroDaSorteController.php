<?php


namespace App\Controllers;

use App\Utils\AcessoNegado;
use Exception;

class CompraNumeroDaSorteController
{


    private $acessoNegado;
    private $compraNumeroModel;


    public function __construct($compraNumeroModel)
    {
        $this->acessoNegado = new AcessoNegado();
        $this->compraNumeroModel = $compraNumeroModel;
    }


    public function regastarNumeros()
    {
        try {
            $token_valid = $this->acessoNegado->verify();

            $cliente_id = $token_valid->cliente_id;

            $numeros = $this->compraNumeroModel->regastarNumeroDaSorte($cliente_id);

            $dados = array();

            foreach ($numeros as  $value) {

                $numeros = array(
                    'id' => $value['id'],
                    'serie' => $value['serie'],
                    'numero' => $value['numero'],
                    'data' => $value['data']
                );
                $dados[] = $numeros;
            }

            $response = [
                'success' => true,
                'dados' => $dados
            ];

            echo json_encode($response);
        } catch (Exception $e) {

            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];


            echo json_encode($response);
        }
    }
}
