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


}
