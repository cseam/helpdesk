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

    public function countReasonForTicketsThisMonth() {
      $database = new Database();
      $database->query("SELECT callreasons.reason_name,
                        count(*) AS last7
                        FROM calls
                        INNER JOIN callreasons ON calls.callreason = callreasons.id
                        WHERE calls.status='2'
                        AND calls.closed >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                        GROUP BY callreasons.reason_name
                      ");
      $result = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() === 0) { return null;}
      // else populate object with db results
      return $result;
    }

    public function countAssignedTickets() {
      $database = new Database();
      $database->query("SELECT helpdesks.helpdesk_name,
                        engineers.idengineers,
                        engineers.engineerName,
                        Count(assigned) AS HowManyAssigned,
                        sum(case when status !=2 THEN 1 ELSE 0 END) AS OpenOnes
                        FROM calls
                        JOIN engineers ON calls.assigned=engineers.idengineers
                        JOIN helpdesks ON engineers.helpdesk=helpdesks.id
                        WHERE engineers.disabled != 1
                        GROUP BY calls.assigned
                        ORDER BY calls.helpdesk
                      ");
      $result = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() === 0) { return null;}
      // else populate object with db results
      return $result;
    }

    public function countDayBreakdownTotalsLastMonth() {
      $database = new Database();
      $database->query("SELECT engineers.engineerName,
                        helpdesks.helpdesk_name,
                        sum(case when hour(calls.closed) < 7 OR hour(calls.lastupdate) < 7 THEN 1 ELSE 0 END) AS '0-7',
                        sum(case when hour(calls.closed) = 7 OR hour(calls.lastupdate) = 7 THEN 1 ELSE 0 END) AS '7-8',
                        sum(case when hour(calls.closed) = 8 OR hour(calls.lastupdate) = 8 THEN 1 ELSE 0 END) AS '8-9',
                        sum(case when hour(calls.closed) = 9 OR hour(calls.lastupdate) = 9 THEN 1 ELSE 0 END) AS '9-10',
                        sum(case when hour(calls.closed) = 10 OR hour(calls.lastupdate) = 10 THEN 1 ELSE 0 END) AS '10-11',
                        sum(case when hour(calls.closed) = 11 OR hour(calls.lastupdate) = 11 THEN 1 ELSE 0 END) AS '11-12',
                        sum(case when hour(calls.closed) = 12 OR hour(calls.lastupdate) = 12 THEN 1 ELSE 0 END) AS '12-13',
                        sum(case when hour(calls.closed) = 13 OR hour(calls.lastupdate) = 13 THEN 1 ELSE 0 END) AS '13-14',
                        sum(case when hour(calls.closed) = 14 OR hour(calls.lastupdate) = 14 THEN 1 ELSE 0 END) AS '14-15',
                        sum(case when hour(calls.closed) = 15 OR hour(calls.lastupdate) = 15 THEN 1 ELSE 0 END) AS '15-16',
                        sum(case when hour(calls.closed) = 16 OR hour(calls.lastupdate) = 16 THEN 1 ELSE 0 END) AS '16-17',
                        sum(case when hour(calls.closed) = 17 OR hour(calls.lastupdate) = 17 THEN 1 ELSE 0 END) AS '17-18',
                        sum(case when hour(calls.closed) = 18 OR hour(calls.lastupdate) = 18 THEN 1 ELSE 0 END) AS '18-19',
                        sum(case when hour(calls.closed) > 19 OR hour(calls.lastupdate) > 19 THEN 1 ELSE 0 END) AS '19-24'
                        FROM engineers
                        JOIN calls ON calls.closeengineerid = engineers.idengineers
                        JOIN helpdesks ON engineers.helpdesk = helpdesks.id
                        WHERE engineers.disabled != 1
                        AND month(calls.closed) = :month
                        AND year(calls.closed) = :year
                        GROUP BY engineers.engineerName
                        ORDER BY helpdesks.id
                      ");
      $database->bind(':month', date("m", strtotime("first day of previous month")));
      $database->bind(':year', date("o"));
      $result = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() === 0) { return null;}
      // else populate object with db results
      return $result;
    }

    public function countEngineerFeedbackTotals() {
      $database = new Database();
      $database->query("SELECT engineers.engineerName,
                        helpdesks.helpdesk_name,
                        AVG(feedback.satisfaction) as FeedbackAVG,
                        COUNT(calls.callid) as FeedbackCOUNT
                        FROM calls
                        JOIN feedback ON feedback.callid=calls.callid
                        JOIN engineers ON engineers.idengineers=calls.closeengineerid
                        JOIN helpdesks ON engineers.helpdesk = helpdesks.id
                        GROUP BY calls.closeengineerid
                      ");
      $result = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() === 0) { return null;}
      // else populate object with db results
      return $result;
    }

    public function getPoorFeedback() {
      $database = new Database();
      $database->query("SELECT calls.callid,
                        engineers.engineerName,
                        calls.owner,
                        feedback.details,
                        feedback.satisfaction
                        FROM feedback
                        JOIN calls ON feedback.callid=calls.callid
                        JOIN engineers ON engineers.idengineers=calls.closeengineerid
                        WHERE satisfaction IN (1,2)
                      ");
      $result = $database->resultset();
      // if no results return empty object
      if ($database->rowCount() === 0) { return null;}
      // else populate object with db results
      return $result;
    }

    public function GetFailedSLAThisMonth() {
      $database = new Database();
      $database->query("SELECT calls.callid,
                        calls.title,
                        helpdesks.helpdesk_name,
                        engineers.engineerName,
                        calls.urgency,
                        service_level_agreement.close_eta_days,
                        datediff(calls.closed, calls.opened) AS 'total_days_to_close'
                        FROM calls
                        INNER JOIN service_level_agreement ON calls.helpdesk = service_level_agreement.helpdesk
                        JOIN helpdesks ON calls.helpdesk = helpdesks.id
                        JOIN engineers ON engineers.idengineers=calls.assigned
                        WHERE service_level_agreement.urgency = calls.urgency
                        AND Year(closed) = :year
                        AND Month(closed) = :month
                        ORDER BY assigned
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
