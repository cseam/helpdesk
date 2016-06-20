<?php

class actionReportDefault {
  public function __construct()
  {
    //create new models for required data
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    $ticketModel = new ticketModel();
    //set report name
    $reportname = "Day Breakdown";
    //set report title
    $pagedata->title = $reportname . " Report";
    //populate report results for use in view
    $pagedata->reportResults = $ticketModel->countDayBreakdownTotals($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = $reportname. " showing helpdesk activity by time of day, ";
    if (isset($_SESSION['customReportsRangeStart'])) { $pagedata->details .= " from " . $_SESSION['customReportsRangeStart'] . " to " . $_SESSION['customReportsRangeEnd']; } else { $pagedata->details .= " this month."; }
    //render template using $pagedata object
    require_once "views/reports/resultsDayBreakdownReportView.php";
  }
}
