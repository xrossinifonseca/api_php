<?php

namespace App\Router;

use App\Router\CompraRouter;
use App\Router\ClienteRouter;
use App\Router\AuthRouter;
use App\Router\JogoRouter;


class Router
{

    protected $clienteRouter;
    protected $compraRouter;
    protected $authRouter;
    protected $compraNumero;
    protected $jogoRouter;


    public function __construct()
    {
        $this->clienteRouter = new ClienteRouter();
        $this->compraRouter = new CompraRouter();
        $this->authRouter = new AuthRouter();
        $this->compraNumero = new CompraNumeroRouter();
        $this->jogoRouter = new JogoRouter();
    }


    public function chamarRotas()
    {

        $this->clienteRouter->route();
        $this->authRouter->route();
        $this->compraRouter->route();
        $this->compraNumero->route();
        $this->jogoRouter->route();
    }
}
