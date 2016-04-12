<?php

class actionReportAll {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $ticketModel = new ticketModel();
    $helpdeskModel = new helpdeskModel();
    $pagedata = new stdClass();
    //set report name
    $reportname = "All";
    //set report title
    $pagedata->title = $reportname . " Tickets";
    //populate report results for use in view
    $pagedata->reportResults = $ticketModel->getTicketsByHelpdesk($_SESSION['engineerHelpdesk'], 1000);
    //get helpdesk details
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = sizeof($pagedata->reportResults)." ".$reportname." tickets regardless of ticket state, for ".$helpdeskdetails["helpdesk_name"]." helpdesk. (limited to last 1000 tickets)";
    //render template using $pagedata object
    require_once "views/reports/resultsListReportView.php";
  }
}
