<?php

  class ticketModel {
    public function __construct()
    { }

    public function getMyTickets($username) {
      $database = new Database();
      $database->query("SELECT * FROM calls WHERE owner = :username ORDER BY callid DESC");
      $database->bind(":username", $username);
      $results = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() == 0) { return null;}
      // else populate opbject with db results
      return $results;
    }
}
