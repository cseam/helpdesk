<?php

class reportWorkingOnController {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $ticketModel = new ticketModel();
    $pagedata = new stdClass();
    //set report name
    $reportname = "Last Viewed Ticket";
    //set report title
    $pagedata->title = $reportname . ".";
    //populate report results for use in view
    $pagedata->reportResults = $ticketModel->getLastViewedByHelpdesk($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = $reportname." the engineer looked at on helpdesk, with time and date information to help narrow down possible whereabouts.";
    //render template using $pagedata object
    require_once "views/reports/resultsWorkingOnReportView.php";
  }
}
