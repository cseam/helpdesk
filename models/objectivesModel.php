<?php

  class objectivesModel {
    public function __construct()
    { }

    public function getALLObjectivesByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("SELECT * FROM performance_review_objectives JOIN engineers ON performance_review_objectives.engineerid=engineers.idengineers WHERE engineers.helpdesk IN (:helpdesk) AND status !='2' ORDER BY engineers.idengineers");
      $database->bind(':helpdesk', $helpdeskid);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function getObjectivesByEngineerId($engineerid) {
      $database = new Database();
      $database->query("SELECT * FROM performance_review_objectives  WHERE engineerid = :engineerid");
      $database->bind(":engineerid", $engineerid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

}
