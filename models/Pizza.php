<?php 
class Pizza{
    private $conn;
    private $tabela = "pizzas";

    public $idPizza;
    public $nome;
    public $ingredientes;
    public $valor;

    public function __construct($db){
        $this->conn = $db;
    }

    public function getall(){
        $query = "SELECT idPizza, nome, ingredientes, valor FROM " . $this->tabela;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function get(){
        $query = 'SELECT
    idpizza,
    nome,
    ingredientes,
    valor
    FROM ' . $this->tabela . '
    WHERE
        idpizza = ?
    LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idPizza);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->nome = $row['nome'];
        $this->ingredientes = $row['ingredientes'];
        $this->valor = $row['valor'];
    }
}