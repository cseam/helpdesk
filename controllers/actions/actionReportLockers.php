<?php

class actionReportLockers {
  public function __construct()
  {
    //create new models for required data
    $statsModel = new statsModel();
    $helpdeskModel = new helpdeskModel();
    $lockersModel = new lockersModel();
    $pagedata = new stdClass();
    //dont need to populate $listdata as fixed partial in manager view
    //set report name
    $reportname = "Lockers";
    //set report title
    $pagedata->title = $reportname . "";
    //get department workrate for graph
    $stats = $statsModel->countDepartmentWorkrateByDay($_SESSION['engineerHelpdesk']);
    //populate report results for use in view
    $pagedata->reportResults = $lockersModel->getLockersByHelpdesk($_SESSION['engineerHelpdesk']);
    //get helpdesk details
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = sizeof($pagedata->reportResults)." ".$reportname." for ".$helpdeskdetails["helpdesk_name"]." helpdesk.";
    //render template using $pagedata object
    require_once "views/reports/resultsLockersView.php";
  }
}
