<?php
/**
 * =========================================================================
 * O QUE É ESTE FICHEIRO? (bem simples)
 * =========================================================================
 * Igual à ideia do Pizza.php, mas para a tabela `bebidas`. É o "tradutor" entre
 * o PHP e as linhas da base de dados: ler lista, ler uma, criar, atualizar, apagar.
 *
 * A classe chama-se Bebidas (plural) mas cada objeto representa uma bebida / registo.
 */
 
class Bebidas
{
    private $conn;
    private $tabela = "pizzas";
 
    public $idPizzas;
    public $nome;
    public $litros;
    public $valor;
 
    public function __construct($db)
    {
        $this->conn = $db;
    }
 
    /**
     * Lista todas as pizzas da tabela. Devolve o resultado PDO para o getall.php percorrer.
     */
    public function getall()
    {
        $query = "SELECT idPizzas, nome, litros, valor FROM " . $this->tabela;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
 
    /**
     * Uma pizza pelo id em $this->idPizzas. Preenche o objeto se existir; senão devolve false.
     */
    public function get()
    {
        $query = "SELECT idPizzas, nome, litros, valor
            FROM " . $this->tabela . "
            WHERE idPizzas = ?
            LIMIT 1";
 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idPizzas);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
        if ($row) {
            $this->idPizzas = $row['idPizzas'];
            $this->nome = $row['nome'];
            $this->litros = $row['litros'];
            $this->valor = $row['valor'];
        }
 
        return $row;
    }
 
    /**
     * Insere pizza nova; depois guarda o id gerado pelo MySQL em idPizzas.
     */
    public function create()
    {
        $query = "INSERT INTO " . $this->tabela . " (nome, litros, valor) VALUES (:nome, :litros, :valor)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':nome', $this->nome);
        $stmt->bindValue(':litros', $this->litros);
        $stmt->bindValue(':valor', $this->valor);
        if (!$stmt->execute()) {
            return false;
        }
        $this->idPizzas = $this->conn->lastInsertId();
        return true;
    }
 
    /**
     * Atualiza a linha com id = idPizzas. true se alterou alguma coisa.
     */
    public function update()
    {
        $query = "UPDATE " . $this->tabela . "
            SET nome = :nome, litros = :litros, valor = :valor
            WHERE idPizzas = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':nome', $this->nome);
        $stmt->bindValue(':litros', $this->litros);
        $stmt->bindValue(':valor', $this->valor);
        $stmt->bindValue(':id', $this->idPizzas);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
 
   public function delete()
    {
        $query = "DELETE FROM " . $this->tabela . " WHERE idPizzas = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $this->idPizzas);
        if (!$stmt->execute()) {
            return false;
        }
        $this->idPizzas = $this->conn->lastInsertId();
        return true;
    }
}