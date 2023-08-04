<?php

namespace App\Router;

use App\Controllers\CompraController;
use App\Models\CompraModel;
use App\Services\CompraService;



class CompraRouter
{

    private $compraModel;
    private $compraService;
    private $compraController;


    public function __construct()
    {
        $this->compraModel = new CompraModel();
        $this->compraService = new CompraService($this->compraModel);
        $this->compraController = new CompraController($this->compraService);
    }


    public function route()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/cadastrar-compra') {

            return $this->compraController->cadastrarCompra();
        }
    }
}
