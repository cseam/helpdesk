<?php

  class changecontrolModel {
    public function __construct()
    { }

    public function getChangeControlsByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("SELECT changecontrol.stamp, changecontrol.changemade, changecontrol.tags, changecontrol.server, engineers.engineerName FROM changecontrol
                        JOIN engineers ON engineers.idengineers=changecontrol.engineersid
                        WHERE FIND_IN_SET(changecontrol.helpdesk, :helpdesk)
                        ORDER BY changecontrol.stamp DESC");
      $database->bind(':helpdesk', $helpdeskid);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function addChangeControl($engineersid, $stamp, $changemade, $tags, $server, $helpdesk) {
      $database = new Database();
      $database->query("INSERT INTO changecontrol (engineersid, stamp, changemade, tags, server, helpdesk)
                        VALUES (:engineersid, :stamp, :changemade, :tags, :server, :helpdesk)");
      $database->bind(':engineersid', $engineersid);
      $database->bind(':stamp', $stamp);
      $database->bind(':changemade', $changemade);
      $database->bind(':tags', $tags);
      $database->bind(':server', $server);
      $database->bind(':helpdesk', $helpdesk);
      $database->execute();
      return true;
    }

}
