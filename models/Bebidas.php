<?php

class Bebidas {
 
    private $conn;
    private $tabela = "bebidas";
    public $idBebidas;
    public $nome;
    public $litros;
    public $valor;
 
    public function __construct($db) {
        $this->conn = $db;
    }

   
    public function getall(){

        
        $query ="SELECT idBebidas, nome, litros, valor FROM " . $this->tabela;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }


public function get() {

    $query = "SELECT idBebidas, nome, litros, valor 
    FROM " . $this->tabela . " 
    WHERE idBebidas = ? 
    LIMIT 1";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(1, $this->idBebidas);

    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // se não encontrou
    if(!$row){
        return false;
    }

    $this->idBebidas = $row['idBebidas'];
    $this->nome = $row['nome'];
    $this->litros = $row['litros'];
    $this->valor = $row['valor'];

    return true;
}

    public function create() {
        $query = "INSERT INTO " . $this->tabela . " (nome, litros, valor) VALUES (:nome, :litros, :valor)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':nome', $this->nome);
        $stmt->bindValue(':litros', $this->litros);
        $stmt->bindValue(':valor', $this->valor);
        if (!$stmt->execute()) {
            return false;
        }
        $this->idBebidas = $this->conn->lastInsertId();
        return true;
    }

    public function update() {
        $query = "UPDATE " . $this->tabela . "
            SET nome = :nome, litros = :litros, valor = :valor
            WHERE idBebidas = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':nome', $this->nome);
        $stmt->bindValue(':litros', $this->litros);
        $stmt->bindValue(':valor', $this->valor);
        $stmt->bindValue(':id', $this->idBebidas);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

public function delete()
    {
        $query = "DELETE FROM " . $this->tabela . " WHERE idBebidas = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $this->idBebidas);
        if (!$stmt->execute()) {
            return false;
        }
        return $stmt->rowCount() > 0;
    }
}