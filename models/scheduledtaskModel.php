<?php

  class scheduledtaskModel {
    public function __construct()
    { }

    public function getScheduledTasksByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("SELECT * FROM scheduled_calls WHERE helpdesk IN (:helpdesk)");
      $database->bind(':helpdesk', $helpdeskid);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

}
