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
        $senha = $data['senha'];

        try {
            $query = "INSERT INTO users (nome,email,cpf,senha) VALUES (:nome,:email,:cpf,:senha)";

            $stmt =  $this->conexao->prepare($query);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->bindParam(':senha', $senha);


            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erro ao criar usuário " . $e->getMessage());
        }
    }
}
