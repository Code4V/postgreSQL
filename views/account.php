<?php
use PostgreSQLTutorial\PostgreSQLCreateFunction;
use PostgreSQLTutorial\StockDB;

  require('../vendor/autoload.php');

  use PostgreSQLTutorial\Connection;
  use PostgreSQLTutorial\AccountDB;
  use PostgreSQLTutorial\Data\DataTable;

  $pdo = Connection::get()->connect();
  $function = new PostgreSQLCreateFunction($pdo);

  $function->createFunctions();

  $accounts = new AccountDB($pdo);
  $accountList = $accounts->getAccounts();

  $myDataTable = new DataTable($accountList);

  $myDataTable->setTitle('SHESH');

  echo $myDataTable->getTitle();
  echo $myDataTable->getTable();




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
    <h1>Accounts</h1>
    <table class="table table-bordered mt-3">
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Plan</th>
          <th>Effective Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($accountList as $acc): ?>
          <tr>
            <td><?= htmlspecialchars($acc['id']); ?></td>
            <td><?= htmlspecialchars($acc['first_name']); ?></td>
            <td><?= htmlspecialchars($acc['last_name']); ?></td>
            <td><?= htmlspecialchars($acc['plan']); ?></td>
            <td><?= htmlspecialchars($acc['effective_date']); ?></td>
          </tr>
        <?php endforeach; ?>

        
      </tbody>
    </table>

    <?= (new DataTable((new StockDB($pdo))->all()))->setTitle('Stocks')->getTable(); ?>
  </div>
</body>
</html>