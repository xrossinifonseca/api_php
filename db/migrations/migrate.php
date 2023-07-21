<?php


require_once __DIR__ . '/001_create_users_table.php';
require_once './002_make_email_and_cpf_unique.php';

// Verifica se a conexão com o banco de dados está ativa
if ($conexao) {
    criarTabelaUsuarios($conexao);
    make_email_cpf_unique($conexao);
} else {
    echo "Erro ao conectar ao banco de dados.";
}
