<?php



function criarTabela_jogo($conexao)
{
    try {
        $query = "CREATE TABLE IF NOT EXISTS jogo (
            id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            compra_id INT(11) NOT NULL,
            cliente_id INT(11) NOT NULL, 
            data_execucao DATETIME DEFAULT NULL,
            data TIMESTAMP(6) NOT NULL DEFAULT current_timestamp(6),
            KEY cliente_id (cliente_id),
            KEY compra_id (compra_id),
            CONSTRAINT `jogo_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON UPDATE CASCADE,
            CONSTRAINT `jogo_ibfk_2` FOREIGN KEY (`compra_id`) REFERENCES `compra` (`id`) ON UPDATE CASCADE)";

        $conexao->exec($query);

        echo "Tabela jogo criada com sucesso!";
    } catch (PDOException $e) {
        error_log("Erro ao executar migração: " . $e->getMessage());
    }
}
