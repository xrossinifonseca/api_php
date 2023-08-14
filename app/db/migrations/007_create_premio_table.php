<?php



function criarTabela_premio($conexao)
{
    try {
        $query = "CREATE TABLE IF NOT EXISTS premio (
            id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            data DATETIME NOT NULL,
            premio VARCHAR(100) NOT NULL,
            cpf VARCHAR(11) DEFAULT NULL,
            compra_id INT(11) DEFAULT NULL,
            jogo_id INT(11) DEFAULT NULL )";

        $conexao->exec($query);

        echo "Tabela premio criada com sucesso!";
    } catch (PDOException $e) {
        error_log("Erro ao executar migração: " . $e->getMessage());
    }
}
