<?php

class actionReportAll {
  public function __construct()
  {
    // Dont need to populate $listdata as fixed partial in manager view

    // Populate $stats for Graph
    $statsModel = new statsModel();
    $stats = $statsModel->countDepartmentWorkrateByDay($_SESSION['engineerHelpdesk']);
    // Setup pagedata object
    $pagedata = new stdClass();
    // Set report name
    $reportname = "All";
    // populate report results for use in view
    $ticketModel = new ticketModel();
    $pagedata->reportResults = $ticketModel->getTicketsByHelpdesk($_SESSION['engineerHelpdesk'], 1000);
    // get helpdesk details
    $helpdeskModel = new helpdeskModel();
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    // set report title
    $pagedata->title = $reportname . " Tickets";
    // set page details
    $pagedata->details = sizeof($pagedata->reportResults)." ".$reportname." tickets regardless of ticket state, for ".$helpdeskdetails["helpdesk_name"]." helpdesk. (limited to 1000 tickets)";

    // render template using $pagedata object
    // using individual pages, should change to have one page with partial information passed to cut down on repetition.
    require_once "views/reports/resultsListReportView.php";
  }

}
