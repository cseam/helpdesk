<?php

  class helpdeskModel {
  public function __construct()
    { }

    public function getFriendlyHelpdeskName($helpdeskid) {
      $database = new Database();
      $database->query("SELECT * FROM helpdesks WHERE id = :helpdeskid");
      $database->bind(":helpdeskid", $helpdeskid);
      $results = $database->single();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function getListOfHelpdesks() {
      $database = new Database();
      $database->query("SELECT * FROM helpdesks");
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function getListOfHelpdeskWithoutDeactivated() {
      $database = new Database();
      $database->query("SELECT * FROM helpdesks WHERE deactivate !=1 ORDER BY helpdesk_name");
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function getHelpdeskDescription($helpdeskid) {
      $database = new Database();
      $database->query("SELECT * FROM helpdesks WHERE id = :helpdesk");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->single();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function isHelpdeskAutoAssign($helpdeskid) {
      $database = new Database();
      $database->query("SELECT auto_assign, email_on_newticket FROM helpdesks WHERE id = :helpdesk");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->single();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function getSLADetailsByUrgencyId($urgency, $helpdeskid) {
      $database = new Database();
      $database->query("SELECT agreement, close_eta_days FROM service_level_agreement WHERE helpdesk = :helpdesk AND urgency = :urgency");
      $database->bind(":helpdesk", $helpdeskid);
      $database->bind(":urgency", $urgency);
      $result = $database->single();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function getOutOfHoursContactDetailsByHelpdeskId($helpdeskid) {
      $database = new Database();
      $database->query("SELECT * FROM out_of_hours_contact_details WHERE helpdesk = :helpdesk");
      $database->bind(":helpdesk", $helpdeskid);
      $result = $database->single();
      if ($database->rowCount() === 0) { return null;}
      $ofhTime = $result['end_of_day'];
      $ofhMessage = $result['message'];
      $hour = date("G");
      if ($hour > $ofhTime) { return $ofhMessage; } else { return null; }
    }

}
