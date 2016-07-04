<?php

class reportStagnateController {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $ticketModel = new ticketModel();
    $helpdeskModel = new helpdeskModel();
    $pagedata = new stdClass();
    //set report name
    $reportname = "Stagnate";
    //set report title
    $pagedata->title = $reportname . " Tickets";
    //populate report results for use in view
    $pagedata->reportResults = $ticketModel->getStagnateTicketsByHelpdesk($_SESSION['engineerHelpdesk']);
    //get helpdesk details
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = "Report of ".$reportname." tickets where the ticket has not been updated by an enginner in the last 72 hours.<br /><br />". sizeof($pagedata->reportResults)." ".$reportname." tickets for ".$helpdeskdetails["helpdesk_name"]." helpdesk.";
    //render template using $pagedata object
    require_once "views/reports/resultsListReportView.php";
  }
}
