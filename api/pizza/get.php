<?php
//CRIAÇÃO ROTA GET.PHP
// Headers obrigatórios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// Incluir arquivos de banco de dados e modelo
include_once '../../config/Database.php';
include_once '../../models/Pizza.php';
 
// Instanciar o objeto Database e obter a conexão
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Pizza
$pizza = new Pizza($db);
 
$pizza->idPizza = isset($_GET['id']) ? $_GET['id'] : null;
 
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($pizza->idPizza) {
        // Busca a pizza
        $pizza->get();
 
        $pizza_data = get_object_vars($pizza);
 
        // Cria o array de resposta
        $pizza_arr = [
            "id" => $pizza_data['idPizza'] ?? null,
            "nome" => $pizza_data['nome'] ?? null,
            "ingredientes" => $pizza_data['ingredientes'] ?? null,
            "valor" => $pizza_data['valor'] ?? null
        ];
 
        // Converte para JSON e envia a resposta
        // `JSON_PRETTY_PRINT` é opcional, mas deixa o JSON mais legível
        echo json_encode($pizza_arr, JSON_PRETTY_PRINT);
    } else {
        http_response_code(400);
        echo json_encode(
            ["Mensagem" => "ID da pizza não informado."]
        );
    }
} else {
    http_response_code(405);
    echo json_encode(
        ["Mensagem" => "Método não permitido."]
    );
}