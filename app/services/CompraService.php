<?php

namespace App\Services;

use Exception;

class CompraService
{

    private $compraModel;

    public function __construct($compraModel)
    {
        $this->compraModel = $compraModel;
    }


    public function cadastrarCompraSafety($request)
    {
        $requireFilds = array('numero', 'valor', 'cliente_id');
        $missFilds = array();

        foreach ($requireFilds as $fild) {
            if (empty($request[$fild])) {
                $missFilds[] = $fild;
            }
        }

        if (!empty($missFilds)) {
            $fildsResponse = implode(', ', $missFilds);
            throw new Exception("Necessário preencher campo " . $fildsResponse);
            exit;
        }

        $numero = $request['numero'];
        $valor = $request['valor'];
        $cliente_id = $request['cliente_id'];

        if ($valor < 800) {
            throw new Exception("compra não atingiu o limite mínimo para participar.");
            exit;
        }

        $comprasDia = $this->compraModel->comprasPorDia($cliente_id);
        // verifica se atingiu a quantidade de cadastro no dia.
        if ($comprasDia >= 5) {
            throw new Exception("Você atingiu o limite diário de cadastro de compra, tente novamente amanhã.");
            exit;
        }

        //  verifica se a nota fiscal ja existe
        $this->compraModel->isCompraCadastrada($numero);

        // cadastrar compra
        $this->compraModel->cadastrarCompra($request);
    }
}
