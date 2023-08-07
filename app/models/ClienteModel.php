<?php


namespace App\Models;

use App\Db\Consulta;
use App\Utils\Formata;
use DateTime;
use Error;
use PDOException;
use Exception;




class ClienteModel
{
    protected $consulta;
    public $formata;

    public function __construct()
    {
        $this->consulta = new Consulta();
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

            $response = $this->consulta->insertInto($table, $data_safety);

            return $response;
        } catch (PDOException $e) {
            throw new Exception("Erro ao criar usuário " . $e->getMessage());
        }
    }


    public function isRegistered($table, $coluna, $value)
    {

        $response = $this->consulta->SelectWhere($table, $coluna, $value);

        return $response;
    }

    public function getCliente($id)
    {

        try {
            $cliente = $this->consulta->SelectWhere('cliente', 'id', $id);



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


    public function alterarDados($data, $id)
    {
        try {
            $format_data = DateTime::createFromFormat('d/m/Y', $data['data_nascimento']);
            $table = 'cliente';
            $data_safety = [
                'nome' => $data['nome'],
                'email' => $data['email'],
                'data_nascimento' => $format_data->format("Y-m-d"),
                'telefone' => $this->formata->removeCharacters($data['telefone']),
                'endereco' => $data['endereco'],
                'numero' => $data['numero'],
                'complemento' => $data['complemento'],
                'bairro' => $data['bairro'],
                'cidade' => $data['cidade'],
                'cep' => $this->formata->removeCharacters($data['cep']),
                'estado_id' => $data['estado_id'],
            ];

            $this->consulta->updateWhere($table, $data_safety, $id);
        } catch (Exception $e) {
            throw new Error('Falha ao atualizar dados.');
        }
    }


    public function alterarSenha($nova_Senha, $id)
    {
        try {
            $table = 'cliente';

            $data_safety = [
                "senha" => password_hash($nova_Senha, PASSWORD_DEFAULT)
            ];

            $this->consulta->updateWhere($table, $data_safety, $id);
        } catch (Exception $e) {
            throw new Error('Falha ao tentar alterar senha senha.');
        }
    }
}
