<?php

  class callreasonsModel {
    public function __construct()
    { }

    public function getReasonsByHelpdeskId($helpdeskid) {
      $database = new Database();
      $database->query("SELECT callreasons.id,
                        callreasons.reason_name
                        FROM callreasons
                        WHERE helpdesk_id = :helpdesk
                        ");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() === 0) { return null;}
      // else populate object with db results
      return $results;
    }
}
