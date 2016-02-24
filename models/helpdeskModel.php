<?php

  class helpdeskModel {
    public function __construct()
    { }

    public function getFriendlyHelpdeskName($helpdeskid) {
      // function takes $helpdeskid to return object containing details for that helpdesk
      $database = new Database();
      $database->query("SELECT * FROM helpdesks
                        WHERE id = :helpdeskid
                        ");
      $database->bind(":helpdeskid", $helpdeskid);
      $results = $database->single();
      // if no results return empty object
      if ($database->rowCount() == 0) { return null;}
      // else populate object with db results
      return $results;
    }




}
