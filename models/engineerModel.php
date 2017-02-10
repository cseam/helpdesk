<?php

  class engineerModel {

    private $_startrange = null;
    private $_endrangerange = null;
    private $_helpdesks = null;

    public function __construct()
    {
      // populate custom report values
      $this->_startrange = isset($_SESSION['customReportsRangeStart']) ? $_SESSION['customReportsRangeStart'] : date('Y-m-01');
      $this->_endrange = isset($_SESSION['customReportsRangeEnd']) ? $_SESSION['customReportsRangeEnd'] : date('Y-m-t');
      $this->_helpdesks = isset($_SESSION['customReportsHelpdesks']) ? $_SESSION['customReportsHelpdesks'] : null ;
    }

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
                          WHERE helpdesk = :helpdesk
                          AND disabled != 1");
        $database->bind(":helpdesk", $val);
        $results = $database->resultset();
        $engineers = array_merge($engineers, $results);
      }
      if (sizeof($hdary) > 1) {
        $database->query("SELECT * FROM engineers
                          WHERE helpdesk = :helpdesk
                          AND disabled != 1");
        $database->bind(":helpdesk", $helpdeskid);
        $results = $database->resultset();
        $engineers = array_merge($engineers, $results);
      }
      return $engineers;
    }

    public function getListOfEngineersByHelpdeskId2($helpdeskid) {
      // Reworked version of above method needs testing
      $database = new Database();
      $hdary = explode(",", $helpdeskid);
      $engineers = array();

      foreach($hdary as $key => $val) {
      $database->query("SELECT * FROM engineers
                        WHERE helpdesk REGEXP CONCAT('(', :helpdesk , ')[^0-9]|^(' , :helpdesk , ')$')
                        AND disabled != 1");
      $database->bind(":helpdesk", $val);
      $results = $database->resultset();
      $engineers = array_merge($engineers, $results);
      }
      $unique = array_map("unserialize", array_unique(array_map("serialize", $engineers)));
      return $unique;
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

    /**
     * @param stdClass $engineerobject
     */
    public function upsertEngineer($engineerobject) {
      isset($engineerobject->id) ? $this->modifyEngineerById($engineerobject) : $this->addEngineer($engineerobject);
    }

    /**
     * @param stdClass $engineerobject
     */
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

    /**
     * @param stdClass $engineerobject
     */
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

    public function countEngineerTotals($scope = null) {
      isset($scope) ? $helpdesks = $scope : $helpdesks = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"; // fudge for all helpdesks should be count of active helpdesks (//TODO FIX THIS)
      $helpdesks = isset($this->_helpdesks) ? $this->_helpdesks : $helpdesks;

      $database = new Database();
      $database->query("SELECT engineers.engineerName, count(calls.callid) AS Totals FROM calls
                        JOIN engineers ON calls.closeengineerid=engineers.idengineers
                        WHERE calls.status = 2
                        AND FIND_IN_SET(calls.helpdesk, :scope)
                        AND calls.closed BETWEEN :startrange AND :endrange
                        GROUP BY calls.closeengineerid
                        ORDER BY Totals");
      $database->bind(':startrange', $this->_startrange);
      $database->bind(':endrange', $this->_endrange);
      $database->bind(':scope', $helpdesks);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function countEngineerTotalsOutstatnding($scope = null) {
      isset($scope) ? $helpdesks = $scope : $helpdesks = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"; // fudge for all helpdesks should be count of active helpdesks (//TODO FIX THIS)
      $database = new Database();
      $database->query("SELECT engineerName,
                        sum(CASE WHEN calls.status = 1 THEN 1 ELSE 0 END) AS open,
                        sum(CASE WHEN calls.status = 3 THEN 1 ELSE 0 END) AS onhold,
                        sum(CASE WHEN calls.status = 4 THEN 1 ELSE 0 END) AS escalated
                        FROM engineers
                        LEFT JOIN calls ON calls.assigned = engineers.idengineers
                        WHERE FIND_IN_SET(calls.helpdesk, :scope)
                        AND engineers.disabled = 0
                        AND calls.status !=2
                        GROUP BY engineerName
                        ORDER BY engineerName
      ");
      $database->bind(":scope", $helpdesks);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function countDepartmentWorkrateByDay($helpdeskid) {
      $database = new Database();
      $database->query("SELECT engineerName,
                        sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 0 DAY) THEN 1 ELSE 0 END) AS mon,
                        sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 1 DAY) THEN 1 ELSE 0 END) AS tue,
                        sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 2 DAY) THEN 1 ELSE 0 END) AS wed,
                        sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 3 DAY) THEN 1 ELSE 0 END) AS thu,
                        sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 4 DAY) THEN 1 ELSE 0 END) AS fri,
                        sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 5 DAY) THEN 1 ELSE 0 END) AS sat,
                        sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 6 DAY) THEN 1 ELSE 0 END) AS sun,
                        sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 6 DAY) THEN 1 ELSE 0 END) AS total7
                        FROM engineers
                        LEFT JOIN calls ON calls.closeengineerid = engineers.idengineers
                        WHERE engineers.helpdesk IN (:helpdeskid) OR FIND_IN_SET(engineers.helpdesk, :helpdeskid)
                        AND engineers.disabled=0
                        GROUP BY engineerName
                        ORDER BY total7 DESC
                        ");
      $database->bind(":helpdeskid", $helpdeskid);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function countAssistWorkrateByDay($helpdeskid) {
      $database = new Database();
      $database->query("SELECT calls.callid, calls.closed, engineers.engineerName, call_updates.workedwith, calls.helpdesk
                        FROM engineers
                        LEFT JOIN calls ON calls.closeengineerid = engineers.idengineers
                        JOIN call_updates ON calls.callid = call_updates.callid
                        WHERE call_updates.workedwith IS NOT NULL
                        AND calls.helpdesk IN (:helpdeskid)
                        AND calls.closed >= DATE_SUB(CURDATE(),INTERVAL 6 DAY)
                        ");
      $database->bind(":helpdeskid", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      $assistsids = null;
        foreach ($results as &$values) {
          //loop database assists and create long csv of assistsids
          $assistsids .= $values["workedwith"] . ",";
        }
      //trim trailing comma
      $assistsids = rtrim($assistsids, ",");
      //explode csv into array
      $assistsids = explode(",", $assistsids);
      //count unique values
      $assistcount = array_count_values($assistsids);
      // update ids with friendly name for charts $this->getEngineerFriendlyNameById()
      $assistchart = [];
      foreach ($assistcount as $key => $value) {
        $assistchart[$this->getEngineerFriendlyNameById($key)] = $value;
      }
      return $assistchart;
    }

    public function logEngineerAccess($engineerId = 0, $direction = 1) {
      $database = new Database();
      $database->query("INSERT INTO engineers_punchcard (direction, stamp, engineerid)
                        VALUES (:direction, :stamp ,:engineerId)
                        ");
      $database->bind(":engineerId", $engineerId);
      $database->bind(":stamp", date("c"));
      $database->bind(":direction", $direction);
      $database->execute();
      return;
    }

    public function updateEngineerStatus($engineerId = 0, $status = 0) {
      $database = new Database();
      $database->query("UPDATE engineers_status
                        SET engineers_status.status = :status
                        WHERE id = :engineerid
                        ");
      $database->bind(":engineerid", $engineerId);
      $database->bind(":status", $status);
      $database->execute();
      return;
    }

}
