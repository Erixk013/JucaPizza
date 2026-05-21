<?php
/**
 * =========================================================================
 * O QUE FAZ ISTO? (bem simples)
 * =========================================================================
 * APAGAR = remover UMA linha da tabela de pizzas.
 */
 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
 
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 204 No Content");
    exit;
}
 
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(array(["message" => "Método não permitido. Use DELETE."]));
    exit;
}
 
include_once '../../config/Database.php';
include_once '../../models/Pizza.php';
 
$data = json_decode(file_get_contents("php://input")); {
    if (empty($data->idPizza)) {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array(["message" => "Id é obrigatório."]));
        exit;
    }
}
 
$database = new Database();
$db = $database->getConnection();
 
if (!isset($data->idPizza) || $data->idPizza === null) {
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(array(["message" => "Id é obrigatório."]));
    exit;
}
 
$pizza = new Pizza($db);
$pizza->idPizza = $data->idPizza;
 
if ($pizza->delete()) {
    header("HTTP/1.1 200 OK");
    echo json_encode([
        "message" => "Pizza Deletada.",
        "id" => (int) $data->idPizza,
    ]);
} else {
    header("HTTP/1.1 500 Internal Server Error");
    echo json_encode(array(["message" => "Não foi possível deletar a pizza."]));
}