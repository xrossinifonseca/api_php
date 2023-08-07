<?php

namespace App\Router;

use App\Controllers\ClienteController;
use App\Models\ClienteModel;
use App\Services\ClienteService;

class ClienteRouter
{

    private $clienteModel;
    private $clienteService;
    private $clienteController;


    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
        $this->clienteService = new ClienteService($this->clienteModel);
        $this->clienteController = new ClienteController($this->clienteService);
    }


    public function route()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/registrar') {

            return $this->clienteController->createCliente();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/dados-cliente') {

            return $this->clienteController->getCliente();
        }


        if ($_SERVER['REQUEST_METHOD'] === 'PATCH' && $_SERVER['REQUEST_URI'] === '/alterar-dados') {


            return $this->clienteController->alterarDados();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'PATCH' && $_SERVER['REQUEST_URI'] === '/alterar-senha') {


            return $this->clienteController->alterarSenha();
        }
    }
}
