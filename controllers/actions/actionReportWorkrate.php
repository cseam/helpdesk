<?php

class actionReportWorkrate {
  public function __construct()
  {
    //create new models for required data
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    $ticketModel = new ticketModel();
    //set report name
    $reportname = "Closed ticket totals";
    //set report title
    $pagedata->title = $reportname . " Report";
    //populate report results for use in view
    $pagedata->reportResults = $ticketModel->countWorkRateTotals($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = $reportname. " showing engineer workrate by tickets closed this month for " .sizeof($pagedata->reportResults)." engineers.";
    if (isset($_SESSION['customReportsRangeStart'])) { $pagedata->details .= " from " . $_SESSION['customReportsRangeStart'] . " to " . $_SESSION['customReportsRangeEnd']; } else { $pagedata->details .= " this month."; }
    //render template using $pagedata object
    require_once "views/reports/resultsWorkRateReportView.php";
  }
}
