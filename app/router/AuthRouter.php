<?php


namespace App\Router;

use App\Controllers\AuthController;
use App\Services\Auth;



class AuthRouter
{

    private $authService;
    private $authController;


    public function __construct()
    {
        $this->authService = new Auth();
        $this->authController = new AuthController($this->authService);
    }


    public function route()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/login') {

            return $this->authController->loginCliente();
        }
    }
}
