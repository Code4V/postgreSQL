<?php 

declare(strict_types = 1);

namespace PostgreSQLTutorial\Data;

class DataTable {
  private $keys; 
  private $processedTable; 
  private $data;
  function __construct($dataToDisplay) {
    $this->processKeys($dataToDisplay[0]);
    $this->data = $dataToDisplay;
    $this->generateTable();
  }

  private function processKeys(array $arrayToExtractKeys) {
    $this->keys = array_keys($arrayToExtractKeys);
  }


  private function generateHeader() {
    $headTag = '<tr>';
    foreach($this->keys as $header) {
      $headTag .= "<th>". $header ."</th>";
    }
    $headTag .= '</tr>';
    return $headTag;
  }

  private function generateBody() {
    $bodyTag = '';
    foreach($this->data as $item) {
      $bodyTag .= '<tr>';
        for ($i = 0; $i < count($this->keys); $i+=1) {
          $bodyTag .= '<td>'. $item[$this->keys[$i]] . '</td>';
        }
      $bodyTag .= '</tr>';
    }
    return $bodyTag; 
  }

  private function generateTable() {
    $this->processedTable = "<table class='table'>";
    $this->processedTable .= $this->generateHeader();
    $this->processedTable .= $this->generateBody(); 
    $this->processedTable .= "</table>";
  }

  function getKeys() {
    return $this->keys; 
  }
  function getTable() {

    return $this->processedTable;
  }
}


