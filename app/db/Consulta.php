<?php

namespace App\Db;

use App\Db\Database;
use Exception;

class Consulta extends Database
{


    public function insertInto($table, $data)
    {
        try {
            $columns = implode(', ', array_keys($data));
            $values = implode(', ', array_fill(0, count($data), '?'));

            $query = "INSERT INTO $table ($columns) VALUES ($values)";
            $pdo = $this->connect();

            $stmt = $pdo->prepare($query);
            $stmt->execute(array_values($data));

            $id = $pdo->lastInsertId();

            return $id;
        } catch (Exception $e) {

            throw new Exception("Falha ao tentar inserir dados na tabela $table." . $e->getMessage());
        }
    }


    public function SelectWhere($table, $coluna, $value)
    {
        try {
            $query = "SELECT * FROM $table WHERE $coluna = :value";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([
                'value' => $value
            ]);
            $response = $stmt->fetch();
            return $response;
        } catch (Exception $e) {
            throw new Exception('Falha ao recuperar dados.');
        }
    }


    public function deleteWhere($table, $coluna, $value)
    {
        try {
            $query = "DELETE FROM $table WHERE $coluna = :value";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([
                'value' => $value
            ]);
            $stmt->fetch();

            return true;
        } catch (Exception $e) {
            throw new Exception('Falha ao recuperar dados.');
        }
    }
}
