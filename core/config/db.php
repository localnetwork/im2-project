<?php

class Database {
  private $servername; 
  private $username;
  private $password;
  private $database; 
  private $conn; 


  public function __construct() {
    $this->servername = 'database';
    $this->database = 'welljade_db';
    $this->username = 'welljade_user';
    $this->password = 'U2h5K1UFY55EAcAr';

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