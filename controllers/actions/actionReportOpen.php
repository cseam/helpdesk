<?php

class actionReportOpen {
  public function __construct()
  {
    // create new models for required data
      $statsModel = new statsModel();
      $ticketModel = new ticketModel();
      $helpdeskModel = new helpdeskModel();
      $pagedata = new stdClass();
      // Dont need to populate $listdata as fixed partial in manager view

    // Set report name
    $reportname = "Open";
    // set report title
    $pagedata->title = $reportname . " Tickets";

    // Populate $stats for Graph
    $stats = $statsModel->countDepartmentWorkrateByDay($_SESSION['engineerHelpdesk']);
    // populate report results for use in view
    $pagedata->reportResults = $ticketModel->getOpenTicketsByHelpdesk($_SESSION['engineerHelpdesk']);
    // get helpdesk details
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    // set page details
    $pagedata->details = sizeof($pagedata->reportResults)." ".$reportname." tickets for ".$helpdeskdetails["helpdesk_name"]." helpdesk.";

    // render template using $pagedata object
    require_once "views/reports/resultsListReportView.php";
  }

}
