<?php

namespace App\Models;

use App\Db\Consulta;
use Exception;
use PDO;
use PDOException;

class CompraModel
{

    private $consulta;

    public function __construct()
    {
        $this->consulta = new Consulta();
    }



    public function cadastrarCompra($data)
    {

        try {
            return $this->consulta->insertInto('compra', $data);
        } catch (PDOException $e) {
            throw new Exception("Erro ao cadastrar compra " . $e->getMessage());
        }
    }

    public function isCompraCadastrada($numero)
    {
        $result = $this->consulta->SelectWhere('compra', 'numero', $numero);
        if ($result) {
            throw new Exception("nota fiscal ja cadastrada.");
            exit;
        }
    }

    public function comprasPorDia($value)
    {

        try {
            $query = "SELECT COUNT(*) FROM compra WHERE cliente_id = :value AND DATE(data) = CURRENT_DATE()";
            $stmt = $this->consulta->connect()->prepare($query);
            $stmt->execute([
                'value' => $value
            ]);

            $result = $stmt->fetchColumn();


            return $result;
        } catch (PDOException $e) {

            error_log($e->getMessage());

            throw new Exception('Falha ao buscar dados');
        }
    }
}
