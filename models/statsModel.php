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

  }
?>
