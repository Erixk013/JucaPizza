<?php

header("Content-Type: application/json");

include_once '../config/Database.php';
include_once '../models/Bebidas.php';

$database = new Database();
$db = $database->getConnection();

$bebidas = new Bebidas($db);

// verifica se enviou id
if(!isset($_GET['id'])){

    http_response_code(400);

    echo json_encode(array(
        "message" => "ID não informado"
    ));

    exit();
}

$bebidas->idBebidas = $_GET['id'];

// tenta buscar
if($bebidas->get()){

    $bebida_arr = array(
        "idBebidas" => $bebidas->idBebidas,
        "nome" => $bebidas->nome,
        "litros" => $bebidas->litros,
        "valor" => $bebidas->valor
    );

    http_response_code(200);

    echo json_encode($bebida_arr);

} else {

    http_response_code(404);

    echo json_encode(array(
        "message" => "Bebida não encontrada"
    ));
}

?>