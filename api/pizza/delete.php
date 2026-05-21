<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 204 No Content");
    exit;
}

include_once '../../config/Database.php';
include_once '../../models/Bebidas.php';

$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->id)) {
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(array("message" => "Envie JSON com o id da bebida."));
    exit;
}

$database = new Database();
$db = $database->getConnection();
$bebida = new Bebidas($db);

$bebida->idBebidas = $data->id;

if ($bebida->delete()) {
    header("HTTP/1.1 200 OK");
    echo json_encode(array("message" => "Bebida apagada."));
} else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(array("message" => "Não foi possível apagar a bebida."));
}