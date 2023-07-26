<?php


class UserModel
{

    private $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function create($data)
    {

        $nome = $data['nome'];
        $email = $data['email'];
        $cpf = $data['cpf'];
        $data_nascimento = $data['data_nascimento'];
        $telefone = $data['telefone'];
        $endereco = $data['endereco'];
        $numero = $data['numero'];
        $complemento = $data['complemento'];
        $bairro = $data['bairro'];
        $cidade = $data['cidade'];
        $cep = $data['cep'];
        $estado_id = $data['estado_id'];
        $senha = $data['senha'];

        try {
            $query = "INSERT INTO cliente (nome,email,cpf,data_nascimento,telefone,endereco,numero,complemento,bairro,cidade,cep,estado_id,senha) VALUES (:nome,:email,:cpf,:data_nascimento,:telefone,:endereco,:numero,:complemento,:bairro,:cidade,:cep,:estado_id,:senha)";

            $stmt =  $this->conexao->prepare($query);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->bindParam(':data_nascimento', $data_nascimento);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':endereco', $endereco);
            $stmt->bindParam(':numero', $numero);
            $stmt->bindParam(':complemento', $complemento);
            $stmt->bindParam(':bairro', $bairro);
            $stmt->bindParam(':cidade', $cidade);
            $stmt->bindParam(':cep', $cep);
            $stmt->bindParam(':estado_id', $estado_id);
            $stmt->bindParam(':senha', $senha);


            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erro ao criar usuário " . $e->getMessage());
        }
    }
}
