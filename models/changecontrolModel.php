<?php

  class changecontrolModel {
    public function __construct()
    { }

    public function getChangeControlsByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("SELECT *
                        FROM changecontrol
                        WHERE changecontrol.helpdesk IN (:helpdesk)
                      ");
      $database->bind(':helpdesk', $helpdeskid);
      $result = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() === 0) { return null;}
      // else populate object with db results
      return $result;
    }


}
