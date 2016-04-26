<?php

class subscriptionModel {
  public function __construct()
  { }

  public function getSubscriptionEmailsForTicketId($ticketid) {
    $database = new Database();
    $database->query("SELECT engineers.engineerEmail
                      FROM call_subscriptions
                      JOIN engineers ON call_subscriptions.engineer_id=engineers.idengineers
                      WHERE call_id = :ticketid
                      ");
    $database->bind(":ticketid", $ticketid);
    $results = $database->resultset();
    if ($database->rowCount() === 0) { return null;}
    return $results;
  }

  public function subscribeEngineerToTicket($engineerid, $ticketid) {
    $database = new Database();
    $database->query("INSERT INTO call_subscriptions (call_id, engineer_id)
                      VALUES (:ticketid, :engineerid)
                      ");
    $database->bind(":engineerid", $engineerid);
    $database->bind(":ticketid", $ticketid);
    $database->execute();
    return $database->lastInsertId();
  }

  public function unsubscribeEngineerFromTicket($engineerid, $ticketid) {
    $database = new Database();
    $database->query("DELETE FROM call_subscriptions
                      WHERE call_id = :ticketid
                      AND engineer_id = :engineerid
                      ");
    $database->bind(":engineerid", $engineerid);
    $database->bind(":ticketid", $ticketid);
    $database->execute();
    return true;
  }

  public function amISuscribedToTicket($engineerid, $ticketid) {
    $database = new Database();
    $database->query("SELECT *
                      FROM call_subscriptions
                      WHERE call_id = :ticketid
                      AND engineer_id = :engineerid
                      ");
    $database->bind(":engineerid", $engineerid);
    $database->bind(":ticketid", $ticketid);
    $results = $database->resultset();
    if ($database->rowCount() === 0) { return false; } else { return true; }
  }

}
