<?php


function criar_tabela_compra($conexao)
{
    try {
        $query = "CREATE TABLE IF NOT EXISTS compra (
            id INT PRIMARY KEY AUTO_INCREMENT,
            numero VARCHAR(44) NOT NULL UNIQUE,
            valor  DECIMAL(10,2) NOT NULL,
            cliente_id INT NOT NULL ,
            data  TIMESTAMP(6) DEFAULT CURRENT_TIMESTAMP,
            situacao INT NOT NULL DEFAULT -1,
            motivo_reprovacao TEXT
        )";
        $conexao->exec($query);
        echo "Tabela compra criada com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao executar migração: " . $e->getMessage();
    }
}
