<?php

  class engineerModel {
    public function __construct()
    { }

    public function getDetailsByUsername($username) {
      $database = new Database();
      $database->query("SELECT * FROM engineers
                        WHERE sAMAccountName = :username");
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
      $hdary = explode(",", $helpdeskid);
      $engineers = array();
      foreach($hdary as $key => $val) {
        $database->query("SELECT * FROM engineers
                          WHERE helpdesk = :helpdesk AND disabled != 1");
        $database->bind(":helpdesk", $val);
        $results = $database->resultset();
        $engineers = array_merge($engineers, $results);
      }
      if (sizeof($hdary) > 1) {
        $database->query("SELECT * FROM engineers
                        WHERE helpdesk = :helpdesk AND disabled != 1");
        $database->bind(":helpdesk", $helpdeskid);
        $results = $database->resultset();
        $engineers = array_merge($engineers, $results);
      }
      return $engineers;
    }

    public function getEngineerFriendlyNameById($engineerid) {
      $database = new Database();
      $database->query("SELECT engineerName FROM engineers
                        WHERE idengineers = :engineer");
      $database->bind(":engineer", $engineerid);
      $result = $database->single();
      return $result["engineerName"];
    }

    public function getNextEngineerIdByHelpdeskId($helpdeskid) {
      $database = new Database();
      $day = "%".date("N")."%";
      //find last engineer used for helpdeskid
      $database->query("SELECT * FROM assign_engineers
                        INNER JOIN engineers ON assign_engineers.engineerid=engineers.idengineers
                        WHERE id= :id");
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
      $database->query("UPDATE assign_engineers
                        SET engineerId = :engineerid
                        WHERE id = :id");
      $database->bind(":id", $helpdeskid);
      $database->bind(":engineerid", $engineerid);
      $database->execute();
      return true;
    }

    public function getListOfEngineers() {
      $database = new Database();
      $database->query("SELECT * FROM engineers
                        ORDER BY helpdesk, engineerName");
      $results = $database->resultset();
      return $results;
    }

    public function disableEngineerById($id) {
      $database = new Database();
      $database->query("UPDATE engineers
                        SET engineers.disabled = 1
                        WHERE engineers.idengineers = :id");
      $database->bind(":id", $id);
      $database->execute();
      return $database->lastInsertId();
    }

    public function upsertEngineer($engineerobject) {
      isset($engineerobject->id) ? $this->modifyEngineerById($engineerobject) : $this->addEngineer($engineerobject);
    }

    public function addEngineer($engineerobject) {
      $database = new Database();
      $database->query("INSERT INTO engineers (engineerName, engineerEmail, availableDays, sAMAccountName, engineerLevel, helpdesk, superuser, disabled, localLoginHash)
                        VALUES (:engineerName, :engineerEmail, :availableDays, :sAMAccountName, :engineerLevel, :helpdesk, :superuser, :disabled, :localLoginHash)
                        ");
      $database->bind(":engineerName", $engineerobject->engineerName);
      $database->bind(":engineerEmail", $engineerobject->engineerEmail);
      $database->bind(":availableDays", $engineerobject->availableDays);
      $database->bind(":sAMAccountName", $engineerobject->sAMAccountName);
      $database->bind(":engineerLevel", $engineerobject->engineerLevel);
      $database->bind(":helpdesk", $engineerobject->helpdesk);
      $database->bind(":superuser", $engineerobject->superuser);
      $database->bind(":disabled", $engineerobject->disabled);
      $database->bind(":localLoginHash", $engineerobject->localLoginHash);
      $database->execute();
      return $database->lastInsertId();
    }

    public function modifyEngineerById($engineerobject) {
      $database = new Database();
      $database->query("UPDATE engineers
                        SET engineers.engineerName = :engineerName,
                            engineers.engineerEmail = :engineerEmail,
                            engineers.availableDays = :availableDays,
                            engineers.sAMAccountName = :sAMAccountName,
                            engineers.engineerLevel = :engineerLevel,
                            engineers.helpdesk = :helpdesk,
                            engineers.superuser = :superuser,
                            engineers.disabled = :disabled,
                            engineers.localLoginHash = :localLoginHash
                        WHERE engineers.idengineers = :id
                        ");
      $database->bind(":id", $engineerobject->id);
      $database->bind(":engineerName", $engineerobject->engineerName);
      $database->bind(":engineerEmail", $engineerobject->engineerEmail);
      $database->bind(":availableDays", $engineerobject->availableDays);
      $database->bind(":sAMAccountName", $engineerobject->sAMAccountName);
      $database->bind(":engineerLevel", $engineerobject->engineerLevel);
      $database->bind(":helpdesk", $engineerobject->helpdesk);
      $database->bind(":superuser", $engineerobject->superuser);
      $database->bind(":disabled", $engineerobject->disabled);
      $database->bind(":localLoginHash", $engineerobject->localLoginHash);
      $database->execute();
      return $database->lastInsertId();
    }

    public function getEngineerById($id) {
      $database = new Database();
      $database->query("SELECT * FROM engineers
                        WHERE idengineers = :id");
      $database->bind(":id", $id);
      $result = $database->single();
      return $result;
    }

}
