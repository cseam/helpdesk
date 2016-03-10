<?php

class actionReportWorkingon {
  public function __construct()
  {
    //create new models for required data
    $statsModel = new statsModel();
    $ticketModel = new ticketModel();
    $pagedata = new stdClass();
    //dont need to populate $listdata as fixed partial in manager view
    //set report name
    $reportname = "Enginners working on";
    //set report title
    $pagedata->title = $reportname . ".";
    //get department workrate for graph
    $stats = $statsModel->countDepartmentWorkrateByDay($_SESSION['engineerHelpdesk']);
    //populate report results for use in view
    $pagedata->reportResults = $ticketModel->getLastViewedByHelpdesk($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = sizeof($pagedata->reportResults)." ".$reportname." the following tickets (last ticket the engineer looked at on helpdesk).";
    //render template using $pagedata object
    require_once "views/reports/resultsWorkingOnReportView.php";
  }
}
