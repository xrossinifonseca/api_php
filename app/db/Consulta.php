<?php

namespace App\Db;

use App\Db\Database;
use Exception;
use PDO;
use PDOException;

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
        } catch (PDOException $e) {
            echo  $e->getMessage();
            throw new Exception("Falha ao cadastrar cliente");
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
        } catch (PDOException $e) {
            echo  $e->getMessage();

            throw new Exception('Falha ao recuperar dados.');
        }
    }


    public function updateWhere($table, $dados, $id)
    {
        try {
            $update = [];

            foreach ($dados as $column => $value) {
                $update[] = "`$column` = :$column";
            }

            $updateString = implode(', ', $update);

            $query = "UPDATE $table SET $updateString WHERE id = :id";
            $pdo = $this->connect();
            $stmt = $pdo->prepare($query);

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            foreach ($dados as $column => $value) {
                $stmt->bindValue(":$column", $value);
            }

            $stmt->execute();
        } catch (PDOException $e) {
            echo  $e->getMessage();

            throw new Exception("Erro ao atualizar dados.");
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
        } catch (PDOException $e) {

            echo  $e->getMessage();

            throw new Exception('Falha ao deletar dados.');
        }
    }
}
