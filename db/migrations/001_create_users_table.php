<?php

require_once './db/conexao.php';
global $conexao;

try {
    $query = "CREATE TABLE users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        nome VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        cpf VARCHAR(255) NOT NULL,
        senha VARCHAR(255) NOT NULL)";


    $conexao->exec($query);
    echo "Migração executada com sucesso.";
} catch (PDOException $e) {
    echo "Erro ao executar migração: " . $e->getMessage();
}
