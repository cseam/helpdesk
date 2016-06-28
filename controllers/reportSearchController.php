<?php

class reportSearchController {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $ticketModel = new ticketModel();
    $helpdeskModel = new helpdeskModel();
    $pagedata = new stdClass();
    //set report name
    $reportname = "search";
    //set report title
    $pagedata->title = $reportname . " tickets";
    //get helpdesk details
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    //populate page default message
    $pagedata->details = "Please enter a search term to search the tickets database";
    //if form submitted query database else render form
    if ($_POST) {
      $pagedata->reportResults = $ticketModel->searchTicketsByTerm($_POST["term"], $_SESSION['engineerHelpdesk']);
      //set page details
      $pagedata->details = "First " . sizeof($pagedata->reportResults)." (limited) ".$reportname." result for '".$_POST["term"]."' on helpdesk.";
    }
    //render template using $pagedata object
    require_once "views/searchView.php";
  }
}
