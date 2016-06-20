<?php

class actionReportHelpdeskbreakdown {
  public function __construct()
  {
    //create new models for required data
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    $helpdeskModel = new helpdeskModel();
    //set report name
    $reportname = "Helpdesk totals";
    //set report title
    $pagedata->title = $reportname . " report";
    //populate report results for use in view
    $pagedata->reportResults = $helpdeskModel->countHelpdeskTotals($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = $reportname. " showing total tickets closed for " .sizeof($pagedata->reportResults)." helpdesks,";
    if (isset($_SESSION['customReportsRangeStart'])) { $pagedata->details .= " from " . $_SESSION['customReportsRangeStart'] . " to " . $_SESSION['customReportsRangeEnd']; } else { $pagedata->details .= " this month."; }
    //render template using $pagedata object
    require_once "views/reports/resultsGraphBarView.php";
  }
}
