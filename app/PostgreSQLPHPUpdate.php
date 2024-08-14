<?php 

namespace PostgreSQLTutorial;

class PostgreSQLPHPUpdate {
  private $pdo;

  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  public function updateStock($id, $symbol, $company) {
    $sql = 'UPDATE stocks '
            . 'SET company = :company,'
            . 'symbol = :symbol '
            . 'WHERE id = :id';

    $stmt = $this->pdo->prepare($sql);

    $stmt->bindValue(':symbol', $symbol);
    $stmt->bindValue(':company', $company);
    $stmt->bindValue(':id', $id);

    $stmt->execute();

    return $stmt->rowCount();
  }
}