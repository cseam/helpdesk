<?php

class actionReportSearch {
  public function __construct()
  {
    //create new models for required data
    $statsModel = new statsModel();
    $ticketModel = new ticketModel();
    $helpdeskModel = new helpdeskModel();
    $pagedata = new stdClass();
    //dont need to populate $listdata as fixed partial in manager view
    //set report name
    $reportname = "search";
    //set report title
    $pagedata->title = $reportname . " tickets";
    //populate $stats for Graph
    $stats = $statsModel->countDepartmentWorkrateByDay($_SESSION['engineerHelpdesk']);
    //get helpdesk details
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    //populate page default message
    $pagedata->details = "Please enter a search term to search the tickets database";
    //if form submitted query database else render form
    if ($_POST) {
      $pagedata->reportResults = $ticketModel->searchTicketsByTerm($_POST["term"]);
      //set page details
      $pagedata->details = "First " . sizeof($pagedata->reportResults)." ".$reportname." result for '".$_POST["term"]."' on helpdesk.";
    }
    //render template using $pagedata object
    require_once "views/searchView.php";
  }
}
