<?php 
class Bebidas{
    private $conn;
    private $tabela = "bebidas";

    public $idBebida;
    public $nome;
    public $litros;
    public $valor;

    public function __construct($db){
        $this->conn = $db;
    }

    public function getall(){
        $query = "SELECT idBebida, nome, litros, valor FROM " . $this->tabela;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function get(){
    $query = 'SELECT
        idBebida,
        nome,
        litros,
        valor
    FROM ' . $this->tabela . '
    WHERE
        idBebida = ?
    LIMIT 1';

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->idBebida);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->nome = $row['nome'];
    $this->litros = $row['litros'];
    $this->idBebida = $row['idBebida'];
    $this->valor = $row['valor'];
    }
}
