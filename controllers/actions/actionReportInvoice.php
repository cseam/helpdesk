<?php

class actionReportInvoice {
  public function __construct()
  {
    // Dont need to populate $listdata as fixed partial in manager view

    // Populate $stats for Graph
    $statsModel = new statsModel();
    $stats = $statsModel->countDepartmentWorkrateByDay($_SESSION['engineerHelpdesk']);
    // Setup pagedata object
    $pagedata = new stdClass();
    // Set report name
    $reportname = "Awaiting Invoice";
    // populate report results for use in view
    $ticketModel = new ticketModel();
    $pagedata->reportResults = $ticketModel->getTicketsForInvoiceByHelpdesk(4);
    // get helpdesk details
    $helpdeskModel = new helpdeskModel();
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    // set report title
    $pagedata->title = $reportname . " Tickets";
    // set page details
    $pagedata->details = sizeof($pagedata->reportResults)." ".$reportname." tickets for ".$helpdeskdetails["helpdesk_name"]." helpdesk.";
    $pagedata->details .= "<br /><br />//TODO setup toggle to update when invoice complete.";
    // render template using $pagedata object
    // using individual pages, should change to have one page with partial information passed to cut down on repetition.
    require_once "views/reports/resultsListReportView.php";
  }

}
