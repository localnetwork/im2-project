<?php

class Database {
  private $servername; 
  private $username;
  private $password;
  private $database; 
  private $conn; 


  public function __construct() {
    $this->servername = 'database';
    $this->database = 'drupal9';
    $this->username = 'drupal9';
    $this->password = 'drupal9';

    try {
        $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

  }

  public function getConnection()
  {
      return $this->conn;
  }
}


?>