<?php

  class lockersModel {
    public function __construct()
    { }

    public function getLockersByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("SELECT *
                        FROM calls
                        JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN status ON calls.status=status.id
                        JOIN location ON calls.location=location.id
                        WHERE calls.lockerid > 0
                        AND calls.helpdesk IN (:helpdesk)
                        ORDER BY lockerid
                      ");
      $database->bind(':helpdesk', $helpdeskid);
      $result = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() === 0) { return null;}
      // else populate object with db results
      return $result;
    }


}
