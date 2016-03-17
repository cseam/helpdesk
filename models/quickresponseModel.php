<?php

  class quickresponseModel {
    public function __construct()
    { }

    public function getQuickResponseByHelpdeskId($helpdeskid) {
      $database = new Database();
      $database->query("SELECT quick_responses.id, quick_responses.quick_response FROM quick_responses WHERE helpdesk_id = :helpdesk");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }
}
