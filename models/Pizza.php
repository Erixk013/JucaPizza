<?php
 
class Pizza
{
    private $conn;
    private $tabela = "pizzas";
    public $idpizza;
    public $idPizza;
    public $nome;
    public $ingredientes;
    public $valor;
 
    public function __construct($conexao)
    {
        $this->conn = $conexao;
    }
 
    private function getIdValue()
    {
        return ($this->idPizza !== null) ? $this->idPizza : $this->idpizza;
    }
 
    public function getall()
    {
        $query = "SELECT idPizza AS idpizza, nome, ingredientes, valor FROM " . $this->tabela;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
 
    public function get()
    {
        $id = $this->getIdValue();
        if (!$id) {
            return false;
        }
 
        $query = "SELECT idPizza AS idpizza, nome, ingredientes, valor FROM " . $this->tabela . " WHERE idPizza = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
        if (!$row) {
            return false;
        }
 
        $this->idpizza = $row['idpizza'];
        $this->idPizza = $row['idpizza'];
        $this->nome = $row['nome'];
        $this->ingredientes = $row['ingredientes'];
        $this->valor = $row['valor'];
 
        return true;
    }
 
    public function find($id)
    {
        $query = "SELECT idPizza AS idpizza, nome, ingredientes, valor FROM " . $this->tabela . " WHERE idPizza = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
 
    public function create()
    {
        $query = "INSERT INTO " . $this->tabela . " (nome, ingredientes, valor) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $success = $stmt->execute(array($this->nome, $this->ingredientes, $this->valor));
 
        if ($success) {
            $this->idpizza = $this->conn->lastInsertId();
            $this->idPizza = $this->idpizza;
        }
 
        return $success;
    }
 
    public function update()
    {
        $id = $this->getIdValue();
        if (!$id) {
            return false;
        }
 
        $query = "UPDATE " . $this->tabela . " SET nome = ?, ingredientes = ?, valor = ? WHERE idPizza = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(array($this->nome, $this->ingredientes, $this->valor, $id));
    }
 
    public function delete($id)
    {
        $query = "DELETE FROM " . $this->tabela . " WHERE idPizza = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(array($id));
    }
 
 
 
    public function add()
    {
        $query = "INSERT INTO " . $this->tabela . " (nome, ingredientes, valor) VALUES (:nome, :ingredientes, :valor)";

        // Preparar a query
        $stmt = $this->conn->prepare($query);

        // Limpar os dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->ingredientes = htmlspecialchars(strip_tags($this->ingredientes));
        $this->valor = htmlspecialchars(strip_tags($this->valor));

        // Vincular os parâmetros
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':ingredientes', $this->ingredientes);
        $stmt->bindParam(':valor', $this->valor);

        // Executar a query
        return $stmt->execute();
    }
}
