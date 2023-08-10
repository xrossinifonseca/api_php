<?php

namespace App\Models;

use App\Db\Consulta;
use PDO;
use PDOException;

class BufferModel
{

    private $consulta;
    public function __construct()
    {
        $this->consulta = new Consulta();
    }

    public function gerarNumeroDaSorte($quantidade)
    {

        try {
            $query = "SELECT b.serie, b.numero FROM buffer b ORDER BY RAND() LIMIT :quantidade";
            $stmt = $this->consulta->connect()->prepare($query);
            $stmt->bindValue(':quantidade', (int)$quantidade, PDO::PARAM_INT);
            $stmt->execute();
            $response = $stmt->fetchAll();
            return $response;
        } catch (PDOException $e) {
            error_log('Erro ao gerar número da sorte' . $e->getMessage());
        }
    }


    public function removerNumeroTabelaBuffer($numero)
    {
        $this->consulta->deleteWhere('buffer', 'numero', $numero);
    }
}
