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

}
