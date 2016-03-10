<?php

class actionReportOutofhours {
  public function __construct()
  {
    // create new models for required data
      $statsModel = new statsModel();
      $helpdeskModel = new helpdeskModel();
      $outofhoursModel = new outofhoursModel();
      $pagedata = new stdClass();
      // Dont need to populate $listdata as fixed partial in manager view

    // Set report name
    $reportname = "Out of hours";
    // set report title
    $pagedata->title = $reportname . "";

    // get department workrate for graph
    $stats = $statsModel->countDepartmentWorkrateByDay($_SESSION['engineerHelpdesk']);
    // populate report results for use in view
    //$pagedata->reportResults = $scheduledtaskModel->gettest($_SESSION['engineerHelpdesk']);
    $pagedata->reportResults = $outofhoursModel->getOutOfHours(1);
    // get helpdesk details
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    // set page details
    $pagedata->details = sizeof($pagedata->reportResults)." ".$reportname." for ".$helpdeskdetails["helpdesk_name"]." helpdesk.";

    // render template using $pagedata object
    require_once "views/reports/resultsOutOfHoursView.php";
  }

}
