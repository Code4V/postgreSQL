<?php 

declare(strict_types = 1);

namespace PostgreSQLTutorial\Data;

class DataTable {
  private $keys; 
  private $processedTable = ''; 
  private $data;
  private $title;


  public function getKeys() {
    return $this->keys; 
  }
  public function getTable() {
    $this->generateTable();

    return $this->processedTable;
  }

  public function getTitle() {
    return $this->title;
  }

  public function setTitle(string $tableTitle) {
    $this->title = $tableTitle;

    return $this;
  }
  function __construct($dataToDisplay) {
    $this->processKeys($dataToDisplay[0]);
    $this->data = $dataToDisplay;
  }

  private function processKeys(array $arrayToExtractKeys) {
    $this->keys = array_keys($arrayToExtractKeys);
  }

  private function generateTitle() {
    $titleTag = '<div>';
    $titleTag .= '<h1>'.$this->title.'</h1>';
    $titleTag .= '</div>';

    return $titleTag;
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
    if (!empty($this->title)) {
      $this->processedTable .= $this->generateTitle(); 
    }
    
    $this->processedTable .= "<table class='table table-bordered'>";
    $this->processedTable .= $this->generateHeader();
    $this->processedTable .= $this->generateBody(); 
    $this->processedTable .= "</table>";
  }
}


