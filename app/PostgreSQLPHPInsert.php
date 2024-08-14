<?php 

namespace PostgreSQLTutorial;

class PostgreSQLPHPInsert {

  private $pdo;

  public function __construct(\PDO $pdo){
    $this->pdo = $pdo;
  }

  public function insertStock($symbol, $company) {
    $sql = 'INSERT INTO stocks(symbol, company) VALUES (:symbol, :company);';
    $stmt = $this->pdo->prepare($sql); 

    $stmt->bindValue(':symbol', $symbol);
    $stmt->bindValue(':company', $company);

    $stmt->execute();

    return $this->pdo->lastInsertId('stocks_id_seq');
  }

  public function insertStockList($stocks) {
    $sql = 'INSERT INTO stocks(symbol, company) VALUES (:symbol, :company);';
    $stmt = $this->pdo->prepare($sql);

    $idList = [];
    foreach ($stocks as $stock) {
      $stmt->bindValue(':symbol', $stock['symbol']);
      $stmt->bindValue(':company', $stock['company']);
      $stmt->execute();
      $idList[] = $this->pdo->lastInsertId('stocks_id_seq');
    }

    return $idList;
  }
}