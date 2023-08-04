<?php

namespace App\Models;

use App\Db\Consulta;
use App\Models\BufferModel;
use Exception;

class CompraNumeroDaSorteModel
{

    private $consulta;
    private $buffer;


    public function __construct()
    {
        $this->consulta = new Consulta();
        $this->buffer = new BufferModel();
    }


    public function salvarNumeroDaSorte($data)
    {
        try {
            $quantidade = $data['quantidade'];
            $compra_id = $data['compra_id'];


            // gerar numero 

            $dataNumeros = $this->buffer->gerarNumeroDaSorte($quantidade);
            foreach ($dataNumeros as $numero) {
                $dados = array(
                    'serie' => $numero['serie'],
                    'numero' => $numero['numero'],
                    'compra_id' => $compra_id
                );

                // salva dados numero da sorte tabela compra_numero_da_sorte
                $this->consulta->insertInto('compra_numero_da_sorte', $dados);

                // deleta numero da sorte gerado tabela buffer
                $this->buffer->removerNumeroTabelaBuffer($dados['numero']);
            }
        } catch (Exception $e) {

            throw new Exception("Falha ao salvar número da sorte no banco de dados.");
        }
    }
}
