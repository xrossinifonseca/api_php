<?php


namespace App\Db;


use PDO;
use PDOException;





class Database
{

    private $bancoDeDados;
    private $porta;
    private $senha;
    private $servidor;
    private $usuario;
    private $sgdb;

    public function __construct()

    {
        $this->servidor = $_ENV['SERVIDOR'];
        $this->bancoDeDados = $_ENV['BANCO_DE_DADOS'];
        $this->usuario = $_ENV['USUARIO'];
        $this->senha = $_ENV['SENHA'];
        $this->porta = $_ENV['PORTA'];
        $this->sgdb = $_ENV['SGDB'];
    }



    public function connect()
    {
        try {
            $dsn = $this->sgdb . ':host=' . $this->servidor . ';port=' . $this->porta . ';dbname=' . $this->bancoDeDados;

            switch ($this->sgdb) {
                case 'mysql':
                    $dsn .= ';charset=utf8mb4';
                    break;
            }


            $conexao =   new PDO(
                $dsn,
                $this->usuario,
                $this->senha,
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );

            return $conexao;
        } catch (PDOException $e) {
            error_log('Falha: ' . $e->getMessage());
            die('Falha ao se conectar com o banco de dados.');
        }
    }
}
