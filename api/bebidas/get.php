<?php
//CRIAÇÃO ROTA GET.PHP
// Headers obrigatórios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// Incluir arquivos de banco de dados e modelo
include_once '../../config/Database.php';
include_once '../../models/Bebidas.php';
 
// Instanciar o objeto Database e obter a conexão
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Pizza
$bebidas = new Bebidas($db);
 
$bebidas->idBebidas = isset($_GET['id']) ? $_GET['id'] : null;
 
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($bebidas->idBebidas) {
        // Busca a pizza
        $bebidas->get();
 
        // Cria o array de resposta
            $bebida_arr = array(
            "id" => $bebidas->idBebidas,
            "nome" => $bebidas->nome,
            "litros" => $bebidas->litros,
            "valor" => $bebidas->valor
        );
 
        // Converte para JSON e envia a resposta
        // `JSON_PRETTY_PRINT` é opcional, mas deixa o JSON mais legível
        echo json_encode($bebida_arr);
    } else {
 
 
    }
}else {
     http_response_code(405);
    echo json_encode(
            array("Mensagem" => "Método não permitido.")
        );
}
 