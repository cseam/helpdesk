<?php

class actionReportOnhold {
  public function __construct()
  {
    // Dont need to populate $listdata as fixed partial in manager view
    // Dont need to populate $stats as fixed partial in manager view

    // Setup pagedata object
    $pagedata = new stdClass();
    // Set report name
    $reportname = "On Hold";
    // populate report results for use in view
    $ticketModel = new ticketModel();
    $pagedata->reportResults = $ticketModel->getTicketsByHelpdesk($_SESSION['engineerHelpdesk'], 100);
    // get helpdesk details
    $helpdeskModel = new helpdeskModel();
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    // set report title
    $pagedata->title = $reportname . " Tickets";
    // set page details
    $pagedata->details = sizeof($pagedata->reportResults)." ".$reportname." tickets for ".$helpdeskdetails["helpdesk_name"]." helpdesk.";

    // render template using $pagedata object
    // using individual pages, should change to have one page with partial information passed to cut down on repetition.
    require_once "views/reports/resultsListReportView.php";
  }

}
