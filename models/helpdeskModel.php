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


}
