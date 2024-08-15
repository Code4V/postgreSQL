<?php 

namespace PostgreSQLTutorial;

class PostgreSQLCreateFunction {
  private $pdo;

  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  public function createFunctions(){

    try {
      $this->pdo->beginTransaction();

      $sql = 'CREATE OR REPLACE FUNCTION get_accounts() RETURNS TABLE (id integer, first_name character varying, last_name character varying, plan character varying, effective_date date) AS ' 
      . ' $$ BEGIN 
        RETURN QUERY 
          SELECT a.id, a.first_name, a.last_name, p.plan, ap.effective_date 
          FROM accounts a
          INNER JOIN account_plans ap on a.id = account_id 
          INNER JOIN plans p on p.id = plan_id 
          ORDER BY a.id, ap.effective_date; 
          END; $$ 
          LANGUAGE plpgsql;'; 


      $this->pdo->exec($sql);

      $this->pdo->commit();
    } catch (\PDOException $e) {

      $this->pdo->rollBack();
      throw $e;
    }

    
    return $this;
  }
}