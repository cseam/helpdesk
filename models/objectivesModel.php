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

    public function getObjectiveById($objectiveid) {
      $database = new Database();
      $database->query("SELECT * FROM performance_review_objectives  WHERE id = :objectiveid");
      $database->bind(":objectiveid", $objectiveid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function updateObjectiveById($objectiveid, $details, $progress) {
      // updates an objective with an engineers comments on progress
      $message = "<div class=update>" . $details . "<h3 class=\"status1\">update by ".$sAMAccountName." - " . date("d/m/Y H:i") . "</h3></div>";
      $database = new Database();
      $database->query("UPDATE performance_review_objectives SET progress=:progress, details = CONCAT(details, :details) WHERE id = :objectiveid");
      $database->bind(":objectiveid", $objectiveid);
      $database->bind(":details", $message);
      $database->bind(":progress", $progress);
      $database->execute();
      return true;
    }

    public function removeObjectiveById($objectiveid) {
      $database = new Database();
      $database->query("DELETE FROM performance_review_objectives WHERE id = :objectiveid");
      $database->bind(":objectiveid", $objectiveid);
      $database->execute();
      return true;
    }

    public function addObjective($objective) {
      $database = new Database();
      $database->query("");
      //$database-bind(":title", $objective->title);
      $database->execute();
      return true;
    }

    public function modifyObjectiveById($objective) {
      // modify objective details once created usualy done by manager
      $database = new Database();
      $database->query("");
      $database->execute();
      return true;
    }

}
