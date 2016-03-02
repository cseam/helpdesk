<?php

class actionReportAll {
  public function __construct()
  {
    // create new models for required data
      $statsModel = new statsModel();
      $ticketModel = new ticketModel();
      $helpdeskModel = new helpdeskModel();
      $pagedata = new stdClass();
      // Dont need to populate $listdata as fixed partial in manager view

    // Set report name
    $reportname = "All";
    // set report title
    $pagedata->title = $reportname . " Tickets";

    // Populate $stats for Graph
    $stats = $statsModel->countDepartmentWorkrateByDay($_SESSION['engineerHelpdesk']);
    // populate report results for use in view
    $pagedata->reportResults = $ticketModel->getTicketsByHelpdesk($_SESSION['engineerHelpdesk'], 1000);
    // get helpdesk details
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    // set page details
    $pagedata->details = sizeof($pagedata->reportResults)." ".$reportname." tickets regardless of ticket state, for ".$helpdeskdetails["helpdesk_name"]." helpdesk. (limited to 1000 tickets)";

    // render template using $pagedata object
    require_once "views/reports/resultsListReportView.php";
  }

}
