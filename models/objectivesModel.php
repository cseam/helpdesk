<?php

  class objectivesModel {
    public function __construct()
    { }

    public function getALLObjectivesByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("SELECT * FROM performance_review_objectives
                        JOIN engineers ON performance_review_objectives.engineerid=engineers.idengineers
                        WHERE FIND_IN_SET(engineers.helpdesk, :helpdesk)
                        AND status !='2'
                        ORDER BY engineers.idengineers");
      $database->bind(':helpdesk', $helpdeskid);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function getObjectivesByEngineerId($engineerid) {
      $database = new Database();
      $database->query("SELECT * FROM performance_review_objectives
                        WHERE engineerid = :engineerid");
      $database->bind(":engineerid", $engineerid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function getObjectiveById($objectiveid) {
      $database = new Database();
      $database->query("SELECT * FROM performance_review_objectives
                        WHERE id = :objectiveid");
      $database->bind(":objectiveid", $objectiveid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function updateObjectiveById($objectiveid, $details, $progress) {
      // updates an objective with an engineers comments on progress
      $message = "<div class=update>" . $details . "<h3 class=\"status1\">update by ".$_SESSION['sAMAccountName']." - " . date("d/m/Y H:i") . "</h3></div>";
      $database = new Database();
      $database->query("UPDATE performance_review_objectives
                        SET progress=:progress, details = CONCAT(details, :details)
                        WHERE id = :objectiveid");
      $database->bind(":objectiveid", $objectiveid);
      $database->bind(":details", $message);
      $database->bind(":progress", $progress);
      $database->execute();
      return true;
    }

    public function removeObjectiveById($objectiveid) {
      $database = new Database();
      $database->query("DELETE FROM performance_review_objectives
                        WHERE id = :objectiveid");
      $database->bind(":objectiveid", $objectiveid);
      $database->execute();
      return true;
    }

    public function addObjective($assignto, $title, $datedue, $details) {
      $database = new Database();
      $database->query("INSERT INTO performance_review_objectives (engineerid, title, details, datedue)
                        VALUES (:assignto, :title, :details, :datedue)");
      $database->bind(":assignto", $assignto);
      $database->bind(":title", $title);
      $database->bind(":datedue", $datedue);
      $database->bind(":details", $details);
      $database->execute();
      return true;
    }

    public function modifyObjectiveById($objectiveid, $title, $details, $datedue) {
      // modify objective details once created usualy done by manager
      $database = new Database();
      $database->query("UPDATE performance_review_objectives
                        SET title=:title, details=:details, datedue=:datedue
                        WHERE id = :objectiveid");
      $database->bind(":title", $title);
      $database->bind(":details", $details);
      $database->bind(":datedue", $datedue);
      $database->bind(":objectiveid", $objectiveid);
      $database->execute();
      return true;
    }

}
