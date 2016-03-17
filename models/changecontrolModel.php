<?php

  class changecontrolModel {
    public function __construct()
    { }

    public function getChangeControlsByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("SELECT changecontrol.stamp, changecontrol.changemade, changecontrol.tags, changecontrol.server, engineers.engineerName FROM changecontrol JOIN engineers ON engineers.idengineers=changecontrol.engineersid WHERE changecontrol.helpdesk IN (:helpdesk) ORDER BY changecontrol.stamp DESC");
      $database->bind(':helpdesk', $helpdeskid);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }


}
