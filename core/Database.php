<?php
require '../config/config.php';

class Database {
  private $host = DB_HOST;
  private $username = DB_USER;
  private $password = DB_PASS;
  private $database = DB_NAME;
  private $mysqli;
  private $stmt;

  public function __construct() {
    $this->mysqli = new mysqli($this->host, $this->username, $this->password, $this->database);
    if ($this->mysqli->connect_errno) {
      echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
    }
  }

  // prepare query
  public function query($query) {
    $this->stmt = $this->mysqli->stmt_init();
    $this->stmt->prepare($query);
  }

  // binding data
  public function bind($types, $values) {
    $this->stmt->bind_param($types, ...$values);
  }

  public function execute() {
    $this->stmt->execute();
  }

  public function resultSet() {
    $this->execute();
    $result = $this->stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function single() {
    $this->execute();
    $result = $this->stmt->get_result();
    return $result->fetch_array(MYSQLI_ASSOC);
  }

  public function rowCount() {
    return $this->stmt->affected_rows;
  }

  public function getResult() {
    $result = $this->stmt->get_result();
    return $result;
  }
}
