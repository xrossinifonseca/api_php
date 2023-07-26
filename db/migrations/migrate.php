<?php


require_once __DIR__ . '/001_create_users_table.php';

// Verifica se a conexão com o banco de dados está ativa
if ($conexao) {
    criarTabelaUsuarios($conexao);
} else {
    echo "Erro ao conectar ao banco de dados.";
}
