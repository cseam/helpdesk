<?php

class reportSearchController {
  public function __construct()
  {
    //create new models for required data 
    $ticketModel = new ticketModel();
    $helpdeskModel = new helpdeskModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Search tickets";
    //get helpdesk details
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    //populate page default message
    $templateData->details = "Please enter a search term to search the tickets database";

    //if form submitted query database else render form
    if ($_POST) {
      $templateData->reportResults = $ticketModel->searchTicketsByTerm($_POST["term"], $_SESSION['engineerHelpdesk']);
      //set page details
      $templateData->details = "First ".sizeof($templateData->reportResults)." (limited) ".$templateData->title." result for '".$_POST["term"]."' on helpdesk.";
    }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('searchView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
