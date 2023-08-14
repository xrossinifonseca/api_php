<?php

use App\Db\Database;
use Dotenv\Dotenv;

require '../../../vendor/autoload.php';
require_once __DIR__ . '/001_create_users_table.php';
require_once __DIR__ . '/002_create_cliente_token.php';
require_once __DIR__ . '/003_create_compra_table.php';
require_once __DIR__ . '/004_create_buffer_table.php';
require_once __DIR__ . '/005_create_compra_numero_da_sorte_table.php';
require_once __DIR__ . '/006_create_jogo_table.php';
require_once __DIR__ . '/007_create_premio_table.php';



require_once '../Database.php';


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$db = new Database();
$conexao =  $db->connect();


// Verifica se a conexão com o banco de dados está ativa
if ($conexao) {
    criarTabelaUsuarios($conexao);
    criarTabelaCliente_token($conexao);
    criar_tabela_compra($conexao);
    criarTabelaBuffer($conexao);
    criarTabelaCompra_numero_da_sorte($conexao);
    criarTabela_jogo($conexao);
    criarTabela_premio($conexao);
} else {
    echo "Erro ao conectar ao banco de dados.";
}
