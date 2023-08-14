<?php


namespace App\Models;

use App\Db\Consulta;
use Exception;
use PDO;
use PDOException;

class JogoModel
{

    private $consulta;


    public function __construct()
    {
        $this->consulta = new Consulta();
    }


    public function cadastrarJogo($dados)
    {
        try {
            $this->validarDados($dados);

            $table = 'jogo';

            $response = $this->consulta->insertInto($table, $dados);

            return $response;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new Exception('Falha ao inserir jogo no banco de dados');
        }
    }


    private function validarDados($dados)
    {


        $cliente_id =  $dados['cliente_id'];
        $compra_id = $dados['compra_id'];

        if (!$cliente_id || !$compra_id) {
            throw new Exception("Falhar ao cadastrar jogo");
            exit;
        }
    }


    public function quantidadeJogo($id)
    {
        try {
            $query = "SELECT COUNT(*) FROM jogo WHERE cliente_id = :id";

            $pdo = $this->consulta->connect();
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $response = $stmt->fetchColumn();

            return $response;
        } catch (PDOException $e) {

            error_log($e->getMessage());
            throw new Exception('Falha ao buscar dados');
        }
    }
}
