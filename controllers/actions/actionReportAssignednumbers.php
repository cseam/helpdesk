<?php

class actionReportAssignednumbers {
  public function __construct()
  {
    //create new models for required data
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    //set report name
    $reportname = "Assigned tickets";
    //set report title
    $pagedata->title = $reportname . " report";
    //populate report results for use in view
    $pagedata->reportResults = $statsModel->countAssignedTickets($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = $reportname. " showing number of tickets assigned, currently open and all time, grouped by engineer.";
    //render template using $pagedata object
    require_once "views/reports/resultsAssignedTicketsView.php";
  }
}
