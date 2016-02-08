<?php

  class statsModel {
    public function __construct()
    { }

    public function countAllTickets() {
      $database = new Database();
      $database->query("SELECT COUNT(*) AS total FROM calls");
      $result = $database->single();
      // if no results return empty object
      if ($database->rowCount() == 0) { return null;}
      // else populate object with db results
      return $result;
    }

  }
?>
