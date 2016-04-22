<?php

  class callreasonsModel {
    public function __construct()
    { }

    public function getReasonsByHelpdeskId($helpdeskid) {
      $database = new Database();
      $database->query("SELECT callreasons.id, callreasons.reason_name FROM callreasons
                        WHERE helpdesk_id IN(:helpdesk)
                        ORDER BY callreasons.reason_name ASC
                        ");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }
}
