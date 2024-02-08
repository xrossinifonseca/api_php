
# API em php

Este é um projeto de API em PHP que utiliza MySQL para armazenamento de dados e JWT (JSON Web Token) para autenticação. O objetivo desta API é fornecer funcionalidades básicas para um sistema de sorteio, permitindo o cadastro de clientes, compras por nota fiscal, a geração de números da sorte e a disponibilização de jogos para o vale-brinde.

## Pré-requisitos

Certifique-se de ter os seguintes requisitos instalados em seu ambiente:

- PHP 7.0 ou superior
- MySQL
- Composer (para gerenciamento de dependências)

## Configuração

1. **Clone o repositório:**

    ```bash
    git clone https://github.com/xrossinifonseca/api_php
    ```

2. **Instale as dependências usando o Composer:**

    ```bash
    composer install
    ```
3. **Configure as credenciais do banco de dados no arquivo `.env`.**


2. **Execute as migrações do banco de dados:**

   Navegue até o diretório `/db/migrations` e execute o seguinte comando no terminal:

   ```bash
   php migrate.php

5. **Configure a chave secreta JWT no arquivo `.env`.**

## Endpoints

A API possui os seguintes endpoints:

### 1. Cadastro de Cliente

- **Endpoint:** `/registrar`
- **Método:** `POST`
- **Corpo da Requisição:**
- `nome` (string, obrigatório)
- `email` (string, obrigatório)
- `cpf` (string, obrigatório)
- `data_nascimento` (string, obrigatório no formato "Y-m-d")
- `telefone` (string, obrigatório)
- `endereco` (string, obrigatório)
- `numero` (string, obrigatório)
- `complemento` (string, opcional)
- `bairro` (string, obrigatório)
- `cidade` (string, obrigatório)
- `cep` (string, obrigatório)
- `estado_id` (int, obrigatório)
- `senha` (string, obrigatório)

### 2. Verificar se CPF do cliente ja está cadastrado
- **Endpoint:** `/verificar-cpf`
- **Método:** `POST`
- **Corpo da Requisição:**
- `cpf` (string, obrigatório)

### 3. Alterar dados
- **Endpoint:** `/alterar-dados`
- **Método:** `POST`
- **Corpo da Requisição:**
- `nome` (string, obrigatório)
- `email` (string, obrigatório)
- `data_nascimento` (string, obrigatório no formato "Y-m-d")
- `telefone` (string, obrigatório)
- `endereco` (string, obrigatório)
- `numero` (string, obrigatório)
- `complemento` (string, opcional)
- `bairro` (string, obrigatório)
- `cidade` (string, obrigatório)
- `cep` (string, obrigatório)
- `estado_id` (int, obrigatório)

### 4. Alterar senha

- **Endpoint:** `/alterar-senha`
- **Método:** `POST`
- **Corpo da Requisição:**
- `senha_atual` (string, obrigatório)
- `nova_senha` (string, obrigatório)

- ### 5. Login
- **Endpoint:** `/login`
- **Método:** `POST`
- **Corpo da Requisição:**
- `cpf` (string, obrigatório)
- `senha` (string, obrigatório)

### 6. Cadastro de Compra por Nota Fiscal

- **Endpoint:** `/cadastrar-compra`
- **Método:** `POST`
- **Corpo da Requisição:**
  - `numero` (int, obrigatório)
  - `valor` (float, obrigatório, necessário ser acima de 800)

### 7. Resgatar números da sorte

- **Endpoint:** `/resgatar-numeros`
- **Método:** `GET`

### 8. Verificar quantidade de jogos

- **Endpoint:** `/quantidade-jogo`
- **Método:** `GET`

## Autenticação

Para acessar os endpoints protegidos, é necessário incluir o token JWT no cabeçalho da requisição:

```bash
Authorization: Bearer SEU_TOKEN_JWT
