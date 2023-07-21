<?php

require_once '../conexao.php';

global $conexao;

function make_email_cpf_unique($conexao)
{
    try {
        $query = "ALTER TABLE users ADD CONSTRAINT unique_email UNIQUE (email),
        ADD CONSTRAINT unique_cpf UNIQUE (cpf)";

        $conexao->exec($query);
        echo "Migração executada com sucesso.";
    } catch (PDOException $e) {
        echo "Error ao executar migração " . $e->getMessage();
    }
}
