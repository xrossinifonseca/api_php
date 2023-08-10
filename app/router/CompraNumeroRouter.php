<?php


namespace App\Router;

use App\Controllers\CompraNumeroDaSorteController;
use App\Models\CompraNumeroDaSorteModel;

class CompraNumeroRouter
{

    private $compraNumeroModel;
    private $compraNumeroController;


    public function __construct()
    {
        $this->compraNumeroModel = new CompraNumeroDaSorteModel();
        $this->compraNumeroController = new CompraNumeroDaSorteController($this->compraNumeroModel);
    }


    public function route()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/regastar-numeros') {

            return $this->compraNumeroController->regastarNumeros();
        }
    }
}
