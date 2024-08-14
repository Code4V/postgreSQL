<?php 

namespace PostgreSQLTutorial;

class StockDB {
  private $pdo;

  public function __construct($pdo){
    $this->pdo = $pdo;
  }

  public function all(){
    $stmt = $this->pdo->query('SELECT id, symbol, company FROM stocks ORDER BY symbol');
    $stocks = [];

    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
      $stocks[] = [
        'id' => $row['id'],
        'symbol' => $row['symbol'],
        'company' => $row['company']
      ];
    }
    
    return $stocks;
  }
}