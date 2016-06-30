<?php

class reportReasonController {
  public function __construct()
  {
    //create new models for required data
    $pagedata = new stdClass();
    $ticketModel = new ticketModel();
    //set report name
    $reportname = "Ticket reported reasons";
    //set report title
    $pagedata->title = $reportname . "";
    //populate report results for use in view
    $pagedata->reportResults = $ticketModel->countReasonForTickets($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = $reportname. " showing tickets closed grouped by the reason the ticket was closed, ";
    if (isset($_SESSION['customReportsRangeStart'])) { $pagedata->details .= " from " . $_SESSION['customReportsRangeStart'] . " to " . $_SESSION['customReportsRangeEnd']; } else { $pagedata->details .= " this month."; }
    //render template using $pagedata object
    require_once "views/reports/resultsGraphBarView.php";
  }
}
