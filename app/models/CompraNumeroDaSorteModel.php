<?php

namespace App\Models;

use App\Db\Consulta;
use App\Models\BufferModel;
use Exception;
use PDO;
use PDOException;

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

    public function regastarNumeroDaSorte($id)
    {

        try {
            $query = "SELECT * FROM compra_numero_da_sorte WHERE compra_id in (SELECT id FROM compra WHERE cliente_id = :id)";

            $pdo = $this->consulta->connect();
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $response = $stmt->fetchAll();

            return $response;
        } catch (PDOException $e) {

            echo 'erro ao recuperar números da sorte ' . $e->getMessage();

            throw new Exception('Falha eu recuperar números da sorte.');
        }
    }
}
