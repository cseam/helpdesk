<?php

  class lockersModel {
    public function __construct()
    { }

    public function getLockersByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("SELECT * FROM calls JOIN engineers ON calls.assigned=engineers.idengineers JOIN status ON calls.status=status.id JOIN location ON calls.location=location.id WHERE calls.lockerid > 0 AND calls.helpdesk IN (:helpdesk) ORDER BY lockerid");
      $database->bind(':helpdesk', $helpdeskid);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function removeItemFromLockerById($callid, $engineername) {
      $who = "<div class=update>Item collected from locker system <h3>Issued by ". $engineername ."," . date("d/m/y h:i") . "</h3></div>";
      $database = new Database();
      $database->query("UPDATE calls SET lockerid=null, lastupdate = :lastupdate, details = CONCAT(details, :details) WHERE callid = :callid");
      $database->bind(':lastupdate', date("c"));
      $database->bind(':details', $who);
      $database->bind(':callid', $callid);
      $result = $database->execute();
      return $result;
    }

}
