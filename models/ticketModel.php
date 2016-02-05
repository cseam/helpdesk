<?php

  class ticketModel {
    public function __construct()
    { }

    public function getMyTickets($username, $limit = 10) {
      // function takes $username and optional $limit to return object containing array of tickets for $username
      $database = new Database();
      $database->query("SELECT * FROM calls
                        INNER JOIN status ON calls.status=status.id
                        WHERE owner = :username
                        ORDER BY callid
                        DESC LIMIT :limit");
      $database->bind(":username", $username);
      $database->bind(":limit", $limit);
      $results = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() == 0) { return null;}
      // else populate object with db results
      return $results;
    }

    public function getAllTickets($limit = 10) {
      // function takes optional $limit to return object containing array of all ticket tickets limited by $limit
      $database = new Database();
      $database->query("SELECT * FROM calls
                        INNER JOIN status ON calls.status=status.id
                        ORDER BY callid
                        DESC LIMIT :limit");
      $database->bind(":limit", $limit);
      $results = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() == 0) { return null;}
      // else populate object with db results
      return $results;
    }

    public function getTicketsByHelpdesk($helpdeskid = 0, $limit = 10) {
      // function takes $helpdeskid and optional $limit to return object containing array of tickets for helpdesk
      $database = new Database();
      $database->query("SELECT * FROM calls
                        INNER JOIN status ON calls.status=status.id
                        WHERE helpdesk = :helpdesk
                        ORDER BY callid
                        DESC LIMIT :limit");
      $database->bind(":helpdesk", $helpdeskid);
      $database->bind(":limit", $limit);
      $results = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() == 0) { return null;}
      // else populate object with db results
      return $results;
    }

    public function getTicketDetails($ticketid) {
      // function takes $ticketid to return object containing ticket details
      $database = new Database();
      $database->query("SELECT * FROM calls
                        WHERE callid = :ticketid");
      $database->bind(":ticketid", $ticketid);
      $result = $database->single();
      // if no results return null
      if ($database->rowCount() == 0) { return null;}
      // else populate object with db results
      return $result;
    }

    public function getOldestTicketByHelpdesk($helpdeskid) {
      // function takes $helpdeskid to return single object containing oldest open ticket details for helpdesk
      $database = new Database();
      $database->query("SELECT * FROM calls
                        INNER JOIN engineers ON calls.assigned=engineers.idengineers
                        INNER JOIN status ON calls.status=status.id
                        INNER JOIN location ON calls.location=location.id
                        WHERE engineers.helpdesk = :helpdesk
                        AND status !='2'
                        ORDER BY opened
                        LIMIT 1");
      $database->bind(":helpdesk", $helpdeskid);
      $result = $database->single();
      // if no results return nulla
      if ($databse->rowCount() == 0) { return null;}
      // else populate object with ticket details
      return $result;
    }

}
