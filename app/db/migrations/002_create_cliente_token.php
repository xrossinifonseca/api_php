<?php



function criarTabelaCliente_token($conexao)
{
    try {
        $query = "CREATE TABLE IF NOT EXISTS cliente_token (
            id INT PRIMARY KEY AUTO_INCREMENT,
            cliente_id INT UNIQUE NOT NULL,
            token VARCHAR(300) UNIQUE NOT NULL,
            validade TIMESTAMP(6) NOT NULL, 
            data  TIMESTAMP(6) DEFAULT CURRENT_TIMESTAMP
        )";

        $conexao->exec($query);
        echo "Tabela cliente_token criada com sucesso! ";
    } catch (PDOException $e) {
        echo "Erro ao executar migração: " . $e->getMessage();
    }
}
