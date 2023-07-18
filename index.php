<?php
header('Content-Type: application/json');


// require_once './db/conexao.php';



if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/') {
    $response = [
        'status' => "success",

    ];

    $jsonResponse = json_encode($response);

    echo $jsonResponse;
}
