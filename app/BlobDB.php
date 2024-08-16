<?php

namespace PostgreSQLTutorial;

class BlobDB {
  private $pdo;

  public function __construct($pdo){
    $this->pdo = $pdo;
  }

  public function insert($stockId, $fileName, $mimeType, $pathToFile) {
    if (!file_exists($pathToFile)) {
      throw new \Exception("File %s not found.");
    }

    $sql = 'INSERT INTO company_files(stock_id, mime_type, file_name, file_data) VALUES (:stock_id, :mime_type, :file_name, :file_data);';

    try {
      $this->pdo->beginTransaction();

      $fileData = $this->pdo->pgsqlLOBCreate();
      $stream = $this->pdo->pgsqlLOBOpen($fileData, 'w');

      $fh = fopen($pathToFile, 'rb');
      stream_copy_to_stream($fh, $stream);

      $fh = null;
      $stream = null;

      $stmt = $this->pdo->prepare($sql);

      $stmt->execute([
        ':stock_id' => $stockId,
        ':mime_type' => $mimeType,
        ':file_name' => $fileName,
        ':file_data' => $fileData,
      ]); 

      $this->pdo->commit();
    } catch (\Exception $e) {
      $this->pdo->rollBack();
      throw $e;
    }

    return $this->pdo->lastInsertId('company_files_id_seq');
  }

  public function read($id) {
    $this->pdo->beginTransaction();

    $stmt = $this->pdo->prepare("SELECT id, file_data, mime_type FROM company_files WHERE id = :id");

    $stmt->execute([$id]);

    $stmt->bindColumn('file_data', $fileData, \PDO::PARAM_STR);
    $stmt->bindColumn('mime_type', $mimeType, \PDO::PARAM_STR);
    $stmt->fetch(\PDO::FETCH_BOUND);
    $stream = $this->pdo->pgsqlLOBOpen($fileData, 'r');



    die();
    header("Content-type: " . $mimeType);

    fpassthru($stream);
    
  }

  public function delete($id) {
    try {
      $this->pdo->beginTransaction();

      $stmt = $this->pdo->prepare('SELECT file_data FROM company_files WHERE id = :id;');

      $stmt->execute([$id]);
      $stmt->bindColumn('file_data', $fileData, \PDO::PARAM_STR);
      $stmt->closeCursor();

      echo $fileData;
      $this->pdo->pgsqlLOBUnlink($fileData);
      $stmt = $this->pdo->prepare('DELETE FROM company_files WHERE id = :id;');
      $stmt->execute([$id]);


      $this->pdo->commit();
    } catch (\Exception $e) {
      $this->pdo->rollBack();
      throw $e;
    }
  }
}