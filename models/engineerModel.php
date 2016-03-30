<?php

  class engineerModel {
    public function __construct()
    { }

    public function getDetailsByUsername($username) {
      $database = new Database();
      $database->query("SELECT * FROM engineers WHERE sAMAccountName = :username");
      $database->bind(":username", $username);
      $row = $database->single();
      if ($database->rowCount() === 0) { return null;}
        // else populate opbject with db results
        $userObject = new stdClass();
        $userObject->sAMAccountName = $row['sAMAccountName'];
        $userObject->engineerLevel = $row['engineerLevel'];
        $userObject->idengineers = $row['idengineers'];
        $userObject->superuser = $row['superuser'];
        $userObject->helpdesk = $row['helpdesk'];
        $userObject->localHash = $row['localLoginHash'];
      return $userObject;
    }

    public function getListOfEngineersByHelpdeskId($helpdeskid) {
      $database = new Database();
      $database->query("SELECT * FROM engineers WHERE helpdesk = :helpdesk AND disabled != 1");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function getEngineerFriendlyNameById($engineerid) {
      $database = new Database();
      $database->query("SELECT engineerName FROM engineers WHERE idengineers = :engineer");
      $database->bind(":engineer", $engineerid);
      $result = $database->single();
      return $result["engineerName"];
    }

    public function getNextEngineerIdByHelpdeskId($helpdeskid) {
      $database = new Database();
      $day = "%".date("N")."%";
      //find last engineer used for helpdeskid
      $database->query("SELECT * FROM assign_engineers INNER JOIN engineers ON assign_engineers.engineerid=engineers.idengineers WHERE id= :id");
      $database->bind(":id", $helpdeskid);
      $results = $database->single();
      $lastengineerid = $results["idengineers"];
      //get next engineer id greater than current id
      $database->query("SELECT idengineers FROM engineers WHERE idengineers > :lastengineerid AND helpdesk = :id AND engineerLevel=1 AND disabled=0 AND availableDays LIKE :available ORDER BY idengineers LIMIT 1");
      $database->bind(":lastengineerid", $lastengineerid);
      $database->bind(":available", $day);
      $database->bind(":id", $helpdeskid);
      $results = $database->single();
      if ($database->rowCount() ===0) {
        //no results so start from beginning of table and accept values less than current id
        $database->query("SELECT idengineers FROM engineers WHERE helpdesk= :id AND engineerLevel=1 AND disabled=0 AND availableDays LIKE :available LIMIT 1");
        $database->bind(":available", $day);
        $database->bind(":id", $helpdeskid);
        $results = $database->single();
      }
      return $results["idengineers"];
    }

    public function updateAutoAssignEngineerByHelpdeskId($helpdeskid, $engineerid) {
      $database = new Database();
      $database->query("UPDATE assign_engineers SET engineerId = :engineerid WHERE id = :id");
      $database->bind(":id", $helpdeskid);
      $database->bind(":engineerid", $engineerid);
      $database->execute();
      return true;
    }

}
