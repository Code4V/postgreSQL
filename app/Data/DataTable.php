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
    $this->buildTable();

    return $this->processedTable;
  }

  public function getTitle() {
    return $this->title;
  }

  public function setTitle(string $tableTitle) {
    $this->title = $tableTitle;

    return $this;
  }
  function __construct(array $dataToDisplay) {
    $this->processKeys($dataToDisplay[0]);
    $this->data = $dataToDisplay;
  }

  private function processKeys(array $arrayToExtractKeys) {
    $this->keys = array_keys($arrayToExtractKeys);
  }

  private function generateTitle(): string{
    $titleTag = '<div>';
    $titleTag .= '<h1>'.$this->title.'</h1>';
    $titleTag .= '</div>';

    return $titleTag;
  }

  private function prettifyWord(array $keys): array {
    $prettified = [];
    foreach($keys as $key) {
      $prettified[] = ucwords(str_replace('_', ' ', $key));
    }
    return $prettified;
  }

  private function generateHeader(): string {
    $headTag = '<tr>';
    foreach($this->prettifyWord($this->keys) as $header) {
      $headTag .= "<th>". $header ."</th>";
    }
    $headTag .= '</tr>';
    return $headTag;
  }

  private function generateBody(): string {
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

  private function buildTable(): void {
    if (!empty($this->title)) {
      $this->processedTable .= $this->generateTitle(); 
    }
    
    $this->processedTable .= "<table class='table table-bordered'>";
    $this->processedTable .= $this->generateHeader();
    $this->processedTable .= $this->generateBody(); 
    $this->processedTable .= "</table>";
  }
}


