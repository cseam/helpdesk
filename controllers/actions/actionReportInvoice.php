<?php

class actionReportInvoice {
  public function __construct()
  {
    // create new models for required data
      $statsModel = new statsModel();
      $ticketModel = new ticketModel();
      $helpdeskModel = new helpdeskModel();
      $pagedata = new stdClass();
      // Dont need to populate $listdata as fixed partial in manager view

    // Set report name
    $reportname = "Awaiting Invoice";
    // set report title
    $pagedata->title = $reportname . " Tickets";

    // Populate $stats for Graph
    $stats = $statsModel->countDepartmentWorkrateByDay($_SESSION['engineerHelpdesk']);
    // populate report results for use in view
    $pagedata->reportResults = $ticketModel->getTicketsForInvoiceByHelpdesk(4);
    // get helpdesk details
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    // set page details
    $pagedata->details = sizeof($pagedata->reportResults)." ".$reportname." tickets for ".$helpdeskdetails["helpdesk_name"]." helpdesk.";
    $pagedata->details .= "<br /><br />//TODO setup toggle to update when invoice complete.";

    // render template using $pagedata object
    require_once "views/reports/resultsListReportView.php";
  }

}
