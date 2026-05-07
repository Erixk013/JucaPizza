<?php
require_once 'config/Database.php';


$database = new Database();
$db = $database->getConnection();

echo "<p style='color: green;'>Conexão bem-sucedida!</p>";
 
echo "<h2>Criando um objeto Pizza...</h2>";
 
// Criamos uma instância da classe Pizza, passando a conexão com o banco
$pizza = new Pizza($db);
 
// Atribuímos valores às suas propriedades públicas
$pizza->nome = 'Margherita';
$pizza->ingredientes = 'Mussarela, fatias de tomate e manjericão fresco';
$pizza->valor = 42.50;
 
// Vamos inspecionar o objeto!
echo "<pre>"; // A tag <pre> ajuda a formatar a saída do print_r
print_r($pizza);
echo "</pre>";
 