<?php

  class outofhoursModel {
    public function __construct()
    { }

    public function getOutOfHours($helpdeskid) {
      $database = new Database();
      $database->query("SELECT *
                        FROM out_of_hours
                        ORDER BY id DESC
                      ");
      $database->bind(':helpdesk', $helpdeskid);
      $result = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() === 0) { return null;}
      // else populate object with db results
      return $result;
    }


}
