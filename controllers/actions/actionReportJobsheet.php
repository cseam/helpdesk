<?php

class actionReportJobsheet {
  public function __construct()
  {
    //create new models for required data
    $statsModel = new statsModel();
    $ticketModel = new ticketModel();
    $pagedata = new stdClass();
    //dont need to populate $listdata as fixed partial in manager view
    //set report name
    $reportname = "Jobs Sheet";
    //set report title
    $pagedata->title = $reportname . "";
    //get department workrate for graph
    $stats = $statsModel->countDepartmentWorkrateByDay($_SESSION['engineerHelpdesk']);
    //populate report results for use in view
    $pagedata->reportResults = $ticketModel->getJobSheetByHelpdesk($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = sizeof($pagedata->reportResults)." outstanding tickets assigned to engineers and listed, grouped by engineer assigned.";
    //render template using $pagedata object
    require_once "views/reports/resultsJobsReportView.php";
  }
}
