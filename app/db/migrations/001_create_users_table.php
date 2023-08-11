<?php



function criarTabelaUsuarios($conexao)
{
    try {
        $query = "CREATE TABLE IF NOT EXISTS cliente (
            id INT PRIMARY KEY AUTO_INCREMENT,
            nome VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            cpf VARCHAR(255) NOT NULL UNIQUE,
            data_nascimento DATE NOT NULL,
            telefone VARCHAR(14) NOT NULL,
            endereco VARCHAR(255) NOT NULL,
            numero VARCHAR(50) NOT NULL,
            complemento VARCHAR(255),
            bairro VARCHAR(255) NOT NULL,
            cep VARCHAR(8) NOT NULL,
            cidade VARCHAR(255) NOT NULL,
            estado_id INT(11) NOT NULL,
            senha VARCHAR(255) NOT NULL,
            data  TIMESTAMP(6) NOT NULL
            
        )";

        $conexao->exec($query);
        echo "Tabela cliente criada com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao executar migração: " . $e->getMessage();
    }
}
