<?php

namespace App\Router;

use App\Router\CompraRouter;
use App\Router\ClienteRouter;
use App\Router\AuthRouter;


class Router
{

    protected $clienteRouter;
    protected $compraRouter;
    protected $authRouter;


    public function __construct()
    {
        $this->clienteRouter = new ClienteRouter();
        $this->compraRouter = new CompraRouter();
        $this->authRouter = new AuthRouter();
    }


    public function chamarRotas()
    {

        $this->clienteRouter->route();
        $this->authRouter->route();
        $this->compraRouter->route();
    }
}
