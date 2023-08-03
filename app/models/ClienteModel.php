<?php


namespace App\Models;

use App\Db\Consulta;
use App\Utils\Formata;
use DateTime;
use PDOException;
use Exception;




class ClienteModel
{
    protected $conexao;
    public $formata;

    public function __construct()
    {
        $this->conexao = new Consulta();
        $this->formata = new Formata();
    }

    public function create($data)
    {
        try {
            $format_data = DateTime::createFromFormat('d/m/Y', $data['data_nascimento']);
            $table = 'cliente';
            $data_safety = [
                'nome' => $data['nome'],
                'email' => $data['email'],
                'cpf' => $this->formata->removeCharacters($data['cpf']),
                'data_nascimento' => $format_data->format("Y-m-d"),
                'telefone' => $this->formata->removeCharacters($data['telefone']),
                'endereco' => $data['endereco'],
                'numero' => $data['numero'],
                'complemento' => $data['complemento'],
                'bairro' => $data['bairro'],
                'cidade' => $data['cidade'],
                'cep' => $this->formata->removeCharacters($data['cep']),
                'estado_id' => $data['estado_id'],
                'senha' => password_hash($data['senha'], PASSWORD_DEFAULT)
            ];

            $response = $this->conexao->insertInto($table, $data_safety);

            return $response;
        } catch (PDOException $e) {
            throw new Exception("Erro ao criar usuário " . $e->getMessage());
        }
    }


    public function isRegistered($table, $coluna, $value)
    {

        $response = $this->conexao->SelectWhere($table, $coluna, $value);
        if ($response) {
            throw new Exception("$coluna ja cadastrado.");
            exit;
        }
    }

    public function getCliente($id)
    {

        try {
            $cliente = $this->conexao->SelectWhere('cliente', 'id', $id);



            $response = [
                "id" => $cliente['id'],
                "nome" => $cliente['nome'],
                "email" => $cliente['email'],
                "cpf" => $cliente['cpf']
            ];



            return $response;
        } catch (Exception $e) {

            throw new Exception("Falha ao buscar usuário");
        }
    }
}
