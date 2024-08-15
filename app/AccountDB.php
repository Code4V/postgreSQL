<?php 

namespace PostgreSQLTutorial;

class AccountDB {
  private $pdo;
  
  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  public function addAccount($firstName, $lastName, $planId, $effectiveDate) {
    try {
      $this->pdo->beginTransaction();

      $accountId = $this->insertAccount($firstName, $lastName);

      $this->insertPlan($accountId, $planId, $effectiveDate);

      $this->pdo->commit();



    } catch (\PDOException $e) {

      $this->pdo->rollBack();
      throw $e;
    }
  }

  private function insertAccount($firstName, $lastName) {
      $stmt = $this->pdo->prepare('INSERT INTO accounts (first_name, last_name) VALUES (:first_name, :last_name);');
  
      $stmt->execute([
        ':first_name' => $firstName,
        ':last_name' => $lastName
      ]);

      return $this->pdo->lastInsertId('accounts_id_seq');
  }

  private function insertPlan($accountId, $planId, $effectiveDate) {
    $stmt = $this->pdo->prepare(
      'INSERT INTO account_plans(account_id, plan_id, effective_date) VALUES (:account_id, :plan_id, :effective_date);'
    );

    return $stmt->execute([
      ':account_id' => $accountId,
      ':plan_id' => $planId,
      ':effective_date' => $effectiveDate,
    ]);

  }

  public function getAccounts() {
    $stmt = $this->pdo->query('SELECT * FROM get_accounts()');
    $accounts = [];

    $stmt->execute();
    while ($row = $stmt->fetch()) {
      $accounts[] = [
        'id' => $row['id'],
        'first_name' => $row['first_name'],
        'last_name' => $row['last_name'],
        'plan' => $row['plan'],
        'effective_date' => $row['effective_date'],
      ];
    }

    return $accounts;
  }
}