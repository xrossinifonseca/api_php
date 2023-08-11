<?php


function generate_numbers()
{
    $numbers = [];
    for ($i = 1; $i <= 100000; $i++) {
        $numbers[] = $i;
    }
    return $numbers;
}



function criarTabelaBuffer($conexao)
{
    try {
        $query = "CREATE TABLE IF NOT EXISTS buffer (
        serie INT NOT NULL,
        numero INT NOT NULL PRIMARY KEY
        )";

        $conexao->exec($query);


        $numeros = generate_numbers();


        $insertQuery = "INSERT INTO buffer (serie,numero) VALUES (:serie,:numero)";
        $stmt = $conexao->prepare($insertQuery);

        foreach ($numeros as $numero) {
            $serie = 0;
            $stmt->execute([
                'numero' => $numero,
                'serie' => $serie
            ]);
        }

        $stmt->fetch();

        echo "Tabela 'buffer' criada e 100.000 números inseridos com sucesso.";
    } catch (PDOException $e) {
        echo "Erro ao executar migração: " . $e->getMessage();
    }
}
