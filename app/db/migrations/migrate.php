<?php

use App\Db\Database;
use Dotenv\Dotenv;

require '../../../vendor/autoload.php';
require_once __DIR__ . '/001_create_users_table.php';
require_once __DIR__ . '/002_create_cliente_token.php';


require_once '../Database.php';


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$db = new Database();
$conexao =  $db->connect();


// Verifica se a conexão com o banco de dados está ativa
if ($conexao) {
    criarTabelaUsuarios($conexao);
    criarTabelaCliente_token($conexao);
} else {
    echo "Erro ao conectar ao banco de dados.";
}
