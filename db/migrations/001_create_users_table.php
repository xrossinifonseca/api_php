<?php

require_once '../conexao.php';

global $conexao;

function criarTabelaUsuarios($conexao)
{
    try {
        $query = "CREATE TABLE IF NOT EXISTS users (
            id INT PRIMARY KEY AUTO_INCREMENT,
            nome VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            cpf VARCHAR(255) NOT NULL,
            senha VARCHAR(255) NOT NULL
        )";



        $conexao->exec($query);
        echo "Tabela de usuários criada com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao executar migração: " . $e->getMessage();
    }
}
