

<?php



function criarTabelaCompra_numero_da_sorte($conexao)
{
    try {
        $query = "CREATE TABLE IF NOT EXISTS compra_numero_da_sorte (
            id int(11) NOT NULL AUTO_INCREMENT,
            compra_id int(11) NOT NULL,
            serie int(11) NOT NULL,
            numero int(11) NOT NULL,
            data timestamp(6) NOT NULL DEFAULT current_timestamp(6),
            PRIMARY KEY (id),
            UNIQUE KEY serie (serie,numero),
            KEY compra_id (compra_id),
            CONSTRAINT compra_numero_da_sorte_ibfk_1 FOREIGN KEY (compra_id) REFERENCES compra (id) ON UPDATE CASCADE     )";

        $conexao->exec($query);
        echo "Tabela de compra_numero_da_sorte criada com sucesso! ";
    } catch (PDOException $e) {
        echo "Erro ao executar migração: " . $e->getMessage();
    }
}
