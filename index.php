<?php 

require 'vendor/autoload.php';

use PostgreSQLTutorial\Connection as Connection;
use PostgreSQLTutorial\PostgreSQLCreateTable as PostgresSQLCreateTable;
use PostgreSQLTutorial\PostgreSQLPHPInsert;
use PostgreSQLTutorial\PostgreSQLPHPUpdate as PostgresSQLUpdate;
use PostgreSQLTutorial\StockDB;


try {

  $pdo = Connection::get()->connect();
  $tableCreator = new PostgresSQLCreateTable($pdo);
  $tableCreator->createTables();

  $createPlans = new PostgreSQLPHPInsert($pdo);
  $createdPlanIds = $createPlans->insertPlansList(['SILVER', 'GOLD', 'PLATINUM']);
  
  $showAllStocks = new StockDB($pdo);


  $stocks = $showAllStocks->all();

} catch (\PDOException $e) {
  echo $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <title>Document</title>
</head>
<body>
  <div class="container">
    <h1>Stock List</h1>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Symbol</th>
          <th>Company</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($stocks as $stock): ?>
          <tr>
            <td><?= htmlspecialchars($stock['id']); ?></td>
            <td><?= htmlspecialchars($stock['symbol']); ?></td>
            <td><?= htmlspecialchars($stock['company']); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>