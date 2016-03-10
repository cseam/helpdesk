<?php

  class scheduledtaskModel {
    public function __construct()
    { }

    public function getScheduledTasksByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("SELECT *
                        FROM scheduled_calls
                        WHERE helpdesk IN (:helpdesk)
                      ");
      $database->bind(':helpdesk', $helpdeskid);
      $result = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() === 0) { return null;}
      // else populate object with db results
      return $result;
    }


}
