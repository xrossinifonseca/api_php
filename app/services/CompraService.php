<?php

namespace App\Services;

use App\Models\CompraNumeroDaSorteModel;
use Exception;

class CompraService
{

    private $compraModel;
    private $compra_numero;
    public function __construct($compraModel)
    {
        $this->compraModel = $compraModel;
        $this->compra_numero = new CompraNumeroDaSorteModel();
    }


    public function cadastrarCompraSafety($request)
    {

        $this->validacaoInput($request);

        $numero = $request['numero'];
        $valor = $request['valor'];
        $cliente_id = $request['cliente_id'];

        if ($valor < 800) {
            throw new Exception("compra não atingiu o limite mínimo para participar.");
            exit;
        }

        // verifica se a nota fiscal ja existe
        $this->compraModel->isCompraCadastrada($numero);


        // verifica se atingiu a quantidade de cadastro no dia.
        $comprasDia = $this->compraModel->comprasPorDia($cliente_id);
        if ($comprasDia >= 5) {
            throw new Exception("Você atingiu o limite diário de cadastro de compra, tente novamente amanhã.");
            exit;
        }

        // cadastrar compra
        $compra_id =  $this->compraModel->cadastrarCompra($request);

        // quantidade participacão
        $quantidade = $this->quantidadeParticipacao($valor);

        // gerar numero da sorte e salvar na tabela compra_numero_da_sorte
        $dadosNumero = [
            "compra_id" => $compra_id,
            "quantidade" => $quantidade
        ];

        $this->compra_numero->salvarNumeroDaSorte($dadosNumero);
    }


    private function validacaoInput($request)
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
    }


    private function quantidadeParticipacao($valor)
    {

        $quantidade  = $valor / 800;


        $quantidadeInt = intval($quantidade);

        return $quantidadeInt;
    }
}
