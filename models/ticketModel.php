<?php

  class ticketModel {
    public function __construct()
    { }

    public function getMyTickets($username, $limit = 10) {
      $database = new Database();
      $database->query("SELECT * FROM calls WHERE owner = :username ORDER BY callid DESC LIMIT :limit");
      $database->bind(":username", $username);
      $database->bind(":limit", $limit);
      $results = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() == 0) { return null;}
      // else populate opbject with db results
      return $results;
    }
}
