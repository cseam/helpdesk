<?php

  class statsModel {
    public function __construct()
    { }

    public function countAllTickets() {
      $database = new Database();
      $database->query("SELECT COUNT(*) AS countAllTickets
                        FROM calls
                        ");
      $result = $database->single();
      // if no results return empty object
      if ($database->rowCount() === 0) { return null;}
      // else populate object with db results
      return $result;
    }

    public function countTicketsByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("SELECT COUNT(*) AS countTicketsByHelpdesk
                        FROM calls
                        WHERE helpdesk = :helpdeskid
                        ");
      $database->bind(":helpdeskid", $helpdeskid);
      $result = $database->single();
      // if no results return empty object
      if ($database->rowCount() === 0) { return null;}
      // else populate object with db results
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
                        WHERE engineers.helpdesk = :helpdeskid
                        AND engineers.disabled=0
                        GROUP BY engineerName
                        ORDER BY total7 DESC
                        ");
      $database->bind(":helpdeskid", $helpdeskid);
      $result = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() === 0) { return null;}
      // else populate object with db results
      return $result;
    }

    public function countEngineerTotalsThisMonth() {
      $database = new Database();
      $database->query("SELECT engineers.engineerName,
                        count(calls.callid) AS Totals
                        FROM calls
                        JOIN engineers ON calls.assigned=engineers.idengineers
                        WHERE status = 2
                        AND Month(closed) = :month
                        AND Year(closed) = :year
                        GROUP BY calls.closeengineerid
                        ORDER BY Totals
                        ");
      $database->bind(':month', date("m"));
      $database->bind(':year', date("o"));
      $result = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() === 0) { return null;}
      // else populate object with db results
      return $result;
    }

    public function countHelpdeskTotalsThisMonth() {
      $database = new Database();
      $database->query("SELECT helpdesks.helpdesk_name,
                        count(calls.callid) AS Totals
                        FROM calls
                        JOIN helpdesks ON calls.helpdesk=helpdesks.id
                        WHERE status = 2
                        AND Month(closed) = :month
                        AND Year(closed) = :year
                        GROUP BY calls.helpdesk, Month(calls.closed)
                        ORDER BY Totals
                      ");
      $database->bind(':month', date("m"));
      $database->bind(':year', date("o"));
      $result = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() === 0) { return null;}
      // else populate object with db results
      return $result;
    }

    public function countCategoryTotalsThisMonth() {
      $database = new Database();
      $database->query("SELECT categories.categoryName,
                        count(calls.callid) AS Totals
                        FROM calls
                        JOIN categories ON calls.category=categories.id
                        WHERE status = 2
                        AND Month(closed) = :month
                        AND Year(closed) = :year
                        GROUP BY calls.category, Month(calls.closed)
                        ORDER BY Totals
                      ");
      $database->bind(':month', date("m"));
      $database->bind(':year', date("o"));
      $result = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() === 0) { return null;}
      // else populate object with db results
      return $result;
    }

    public function countUrgencyTotalsThisMonth() {
      $database = new Database();
      $database->query("SELECT calls.urgency,
                        count(calls.callid) AS Totals
                        FROM calls
                        JOIN categories ON calls.category=categories.id
                        WHERE status = 2
                        AND Month(closed) = :month
                        AND Year(closed) = :year
                        GROUP BY calls.urgency, Month(calls.closed)
                        ORDER BY Totals
                      ");
      $database->bind(':month', date("m"));
      $database->bind(':year', date("o"));
      $result = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() === 0) { return null;}
      // update array values with friendly name as they arent in the db!!!!
      foreach($result as $key => $value) {
        $result[$key]["urgency"] = urgency_friendlyname(array_values($value)[0]);
      }
      return $result;
    }

    public function countPlannedVsReactiveTotalsThisMonth() {
      $database = new Database();
      $database->query("SELECT calls.pm,
                        count(calls.callid) AS Totals
                        FROM calls
                        WHERE status = 2
                        AND Month(closed) = :month
                        AND Year(closed) = :year
                        GROUP BY calls.pm
                        ORDER BY Totals
                      ");
      $database->bind(':month', date("m"));
      $database->bind(':year', date("o"));
      $result = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() === 0) { return null;}
      // else populate object with db results
      // update array values with friendly name as they arent in the db!!!!
      foreach($result as $key => $value) {
        ($result[$key]["pm"] == 1 ? $result[$key]["pm"] = "Planned Tickets" : $result[$key]["pm"] = "Reactive Tickets");
      }
      return $result;
    }

    public function countTotalsThisYear($year) {
      $database = new Database();
      $database->query("SELECT Month(closed) AS MonthNum,
                        count(callid) AS Totals
                        FROM calls
                        WHERE status = 2
                        AND Year(closed) = :year
                        GROUP BY Month(closed)
                        ORDER BY MonthNum, helpdesk
                      ");
      $database->bind(':year', $year);
      $result = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() === 0) { return null;}
      // else populate object with db results
      return $result;
    }

    public function countWorkRateTotalsThisMonth() {
      $database = new Database();
      $database->query("SELECT engineers.engineerName,
                         helpdesks.helpdesk_name,
                        sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 6 DAY) THEN 1 ELSE 0 END) AS Last7,
                        sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 1 DAY) THEN 1 ELSE 0 END) AS Last1,
                        sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 30 DAY) THEN 1 ELSE 0 END) AS Last30
                        FROM engineers
                        JOIN calls ON calls.closeengineerid = engineers.idengineers
                        JOIN helpdesks ON engineers.helpdesk=helpdesks.id
                        WHERE engineers.disabled != 1
                        AND Month(closed) = :month
                        AND Year(closed) = :year
                        GROUP BY engineers.engineerName
                        ORDER BY Last30 DESC
                        ");
      $database->bind(':month', date("m"));
      $database->bind(':year', date("o"));
      $result = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() === 0) { return null;}
      // else populate object with db results
      return $result;
    }

  }
?>
