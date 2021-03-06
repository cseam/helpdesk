<?php
class Database {
  // pull in settings from config.php
  private $host = DB_LOC;
  private $user = DB_USER;
  private $pass = DB_PASSWORD;
  private $dbname = DB_SCHEMA;

  private $dbh;
  private $error;
  private $stmt;

  public function __construct() {
    // Set DSN
      $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname;
    // PDO_MYSQL
    try {
      $this->dbh = new PDO($dsn, $this->user, $this->pass);
    } catch (PDOException $error) {
      echo $error->getMessage();
    }
  }

  public function query($query) {
    $this->stmt = $this->dbh->prepare($query);
  }

  public function bind($param, $value, $type = null) {
    if (is_null($type)) {
      switch (true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
      }
    }
    $this->stmt->bindValue($param, $value, $type);
  }

  public function execute() {
    return $this->stmt->execute();
  }

  public function resultset() {
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function single() {
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function rowCount() {
    return $this->stmt->rowCount();
  }

  public function lastInsertId() {
    return $this->dbh->lastInsertId();
  }

  public function debugDumpParams() {
    return $this->stmt->debugDumpParams();
  }

}
