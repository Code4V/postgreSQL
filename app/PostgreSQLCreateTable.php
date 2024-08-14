<?php

namespace PostgreSQLTutorial;

class PostgreSQLCreateTable {

  private $pdo;

  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  public function createTables() {
    $sqlList = ['CREATE TABLE IF NOT EXISTS stocks (
      id SERIAL PRIMARY KEY,
      symbol CHARACTER VARYING(10) NOT NULL UNIQUE,
      company CHARACTER VARYING(255) NOT NULL UNIQUE
    );
    ', 'CREATE TABLE IF NOT EXISTS stock_evaluations (
      stock_id INTEGER NOT NULL,
      value_on DATE NOT NULL,
      price NUMERIC(8, 2) NOT NULL DEFAULT 0,
      PRIMARY KEY (stock_id, value_on),
      FOREIGN KEY (stock_id)
        REFERENCES stocks (id)
    );'];

  foreach ($sqlList as $sql) {
    $this->pdo->exec($sql);
  }

  return $this;
  }

  public function getTables() {
    $stmt = $this->pdo->query("SELECT table_name 
                                FROM information_schema.tables
                                WHERE table_schema= 'public'
                                  AND table_type='BASE TABLE'
                                ORDER BY table_name;");
    $tableList = [];
    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
      $tableList[] = $row['table_name'];
    }

    return $tableList;
  }
}