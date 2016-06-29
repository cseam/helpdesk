<?php

  class statsModel {
    public function __construct()
    { }

    public function countAllTickets() {
      $database = new Database();
      $database->query("SELECT COUNT(*) AS countAllTickets
                        FROM calls");
      $result = $database->single();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function countAllOpenTickets() {
      $database = new Database();
      $database->query("SELECT COUNT(*) AS countAllOpenTickets
                        FROM calls
                        WHERE status !=2");
      $result = $database->single();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function countTicketsByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("SELECT COUNT(*) AS countTicketsByHelpdesk
                        FROM calls
                        WHERE helpdesk IN (:helpdeskid)");
      $database->bind(":helpdeskid", $helpdeskid);
      $result = $database->single();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function countTicketsByStatusCode($statuscode, $scope = null) {
      isset($scope) ? $helpdesks = $scope : $helpdesks = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"; // fudge for all helpdesks should be count of active helpdesks (//TODO FIX THIS)
      $database = new Database();
      $database->query("SELECT COUNT(*) AS countTotal
                        FROM calls
                        WHERE status = :status
                        AND FIND_IN_SET(calls.helpdesk, :scope)");
      $database->bind(":status", $statuscode);
      $database->bind(":scope", $helpdesks);
      $result = $database->single();
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

    public function countTicketsByOwner($owner) {
      $database = new Database();
      $database->query("SELECT COUNT(*) AS countTicketsByOwner
                        FROM calls
                        WHERE owner = :owner");
      $database->bind(":owner", $owner);
      $result = $database->single();
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

    public function countTotalsThisYear($year) {
      $database = new Database();
      $database->query("SELECT Month(closed) AS MonthNum, count(callid) AS Totals
                        FROM calls
                        WHERE status = 2
                        AND Year(closed) = :year
                        GROUP BY Month(closed)
                        ORDER BY MonthNum, helpdesk");
      $database->bind(':year', $year);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function countTotalsThisYearbyHelpdesk($year,$helpdesk) {
      $database = new Database();
      $database->query("SELECT MONTH(calls.closed) AS MonthNum, count(calls.callid) AS Totals
                        FROM calls
                        JOIN helpdesks ON calls.helpdesk=helpdesks.id
                        WHERE calls.status = 2
                        AND calls.helpdesk = :helpdesk
                        AND Year(calls.closed) = :year
                        GROUP BY Month(calls.closed)
                        ORDER BY MonthNum, calls.helpdesk");
      $database->bind(':helpdesk', $helpdesk);
      $database->bind(':year', $year);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function avgHelpdeskFeedback() {
      $database = new Database();
      $database->query("SELECT AVG(feedback.satisfaction) as FeedbackAVG
                        FROM calls
                        JOIN feedback ON feedback.callid=calls.callid
                        JOIN engineers ON engineers.idengineers=calls.closeengineerid
                        JOIN helpdesks ON engineers.helpdesk = helpdesks.id
                        WHERE calls.status = 2
                        GROUP BY calls.status");
      $result = $database->single();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function avgHelpdeskFeedbackByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("SELECT AVG(feedback.satisfaction) as FeedbackAVG
                        FROM calls
                        JOIN feedback ON feedback.callid=calls.callid
                        JOIN engineers ON engineers.idengineers=calls.closeengineerid
                        JOIN helpdesks ON engineers.helpdesk = helpdesks.id
                        WHERE calls.status = 2
                        AND calls.helpdesk = :helpdesk
                        GROUP BY calls.status");
      $database->bind(':helpdesk', $helpdeskid);
      $result = $database->single();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function countEngineerTotalsLastWeek($engineerId) {
      $database = new Database();
      $database->query("SELECT DATE_FORMAT(closed, '%a') AS DAY_OF_WEEK
                        FROM calls
                        WHERE closeengineerid = :engineerId
                        AND closed >= DATE_SUB(CURDATE(),INTERVAL 1 WEEK)");
      $database->bind(':engineerId', $engineerId);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      $engineermon = $engineertue = $engineerwed = $engineerthu = $engineerfri = $engineersat = $engineersun = 0;

      foreach($result as $key => $value) {
        SWITCH ($value["DAY_OF_WEEK"]) {
          CASE "Mon":
            ++$engineermon;
            break;
          CASE "Tue":
            ++$engineertue;
            break;
          CASE "Wed":
            ++$engineerwed;
            break;
          CASE "Thu":
            ++$engineerthu;
            break;
          CASE "Fri":
            ++$engineerfri;
            break;
          CASE "Sat":
            ++$engineersat;
            break;
          CASE "Sun":
            ++$engineersun;
            break;
        }
      }
      $count = array();
      $count["Mon"] = $engineermon;
      $count["Tue"] = $engineertue;
      $count["Wed"] = $engineerwed;
      $count["Thu"] = $engineerthu;
      $count["Fri"] = $engineerfri;
      $count["Sat"] = $engineersat;
      $count["Sun"] = $engineersun;
      return $count;
    }

    public function countClosedByEngineerIdLastWeek($engineerId) {
      $database = new Database();
      $database->query("SELECT count(closeengineerid) AS engineerClose
                        FROM calls
                        WHERE closed >= DATE_SUB(CURDATE(),INTERVAL 1 WEEK)
                        AND closeengineerid = :engineerId ");
      $database->bind(':engineerId', $engineerId);
      $result = $database->single();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function countAllTicketsByEngineerIdLastWeek($engineerId) {
      $database = new Database();
      $database->query("SELECT count(callid) AS engineerAll
                        FROM calls
                        WHERE lastupdate >= DATE_SUB(CURDATE(),INTERVAL 1 WEEK)
                        AND assigned = :engineerId");
      $database->bind(':engineerId', $engineerId);
      $result = $database->single();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function avgCloseTimeInDays() {
      $database = new Database();
      $database->query("SELECT helpdesks.helpdesk_name, avg(datediff(calls.closed, calls.opened)) as avg_days
                        FROM calls
                        JOIN helpdesks ON calls.helpdesk = helpdesks.id
                        GROUP BY helpdesk");
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null; }
      return $results;
    }

    public function advCloseTimeByHelpdeskIdInDays($helpdesk) {
      $database = new Database();
      $database->query("SELECT avg(datediff(calls.closed, calls.opened)) as avg_days
                        FROM calls
                        JOIN helpdesks ON calls.helpdesk = helpdesks.id
                        WHERE calls.helpdesk = :helpdesk
                        GROUP BY calls.helpdesk");
      $database->bind(':helpdesk', $helpdesk);
      $results = $database->single();
      if ($database->rowCount() === 0) { return 0; }
      return $results;
    }

    public function countOutstandingTicketsByHelpdesk($helpdesk) {
      $database = new Database();
      $database->query("SELECT count(calls.callid) as outstanding
                        FROM calls
                        JOIN helpdesks ON calls.helpdesk = helpdesks.id
                        WHERE calls.status != 2
                        AND calls.helpdesk = :helpdesk
                        GROUP BY calls.helpdesk");
      $database->bind(':helpdesk', $helpdesk);
      $results = $database->single();
      if ($database->rowCount() ===0) { return 0; }
      return $results;
    }


  }
