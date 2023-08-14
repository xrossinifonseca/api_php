<?php

namespace App\Services;

use Exception;

class JogoService
{

    private $jogoModel;


    public function __construct($jogoModel)
    {
        $this->jogoModel = $jogoModel;
    }


    public function quantidadeJogoValidado($id)
    {

        if (!$id) {
            throw new Exception('cliente é obrigatório');
            exit;
        }

        $quantidade = $this->jogoModel->quantidadeJogo($id);

        return $quantidade;
    }
}
