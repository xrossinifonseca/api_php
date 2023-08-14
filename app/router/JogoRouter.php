<?php


namespace App\Router;

use App\Controllers\JogoController;
use App\Models\JogoModel;
use App\Services\JogoService;

class JogoRouter
{

    private $jogoModel;
    private $jogoService;
    private $jogoController;


    public function __construct()
    {
        $this->jogoModel = new JogoModel();
        $this->jogoService = new JogoService($this->jogoModel);
        $this->jogoController = new JogoController($this->jogoService);
    }


    public function route()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/quantidade-jogo') {

            return $this->jogoController->quantidadeJogo();
        }
    }
}
