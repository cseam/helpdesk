<?php

class reportOutstandingController {
  public function __construct()
  {
    //create new models for required data
    $ticketModel = new ticketModel();
    $engineerModel = new engineerModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Outstanding Totals";
    //set page details
    $templateData->details = "Outstanding ticket totals count first by status then by engineer.";
    //get helpdesks
    $helpdesks = isset($_SESSION['customReportsHelpdesks']) ? $_SESSION['customReportsHelpdesks'] : $_SESSION['engineerHelpdesk'];
    //populate report results for use in view
    $templateData->open = $ticketModel->countTicketsByStatusCode(1, $helpdesks);
    $templateData->escalated = $ticketModel->countTicketsByStatusCode(4, $helpdesks);
    $templateData->onhold = $ticketModel->countTicketsByStatusCode(3, $helpdesks);
    $templateData->sentaway = $ticketModel->countTicketsByStatusCode(5, $helpdesks);
    $templateData->unassigned = sizeof($ticketModel->getUnassignedTicketsByHelpdesk($helpdesks));
    $templateData->over7days = sizeof($ticketModel->get7DayTicketsByHelpdesk($helpdesks));
    $templateData->stagnate = sizeof($ticketModel->getStagnateTicketsByHelpdesk($helpdesks));
    $templateData->reportResults = $engineerModel->countEngineerTotalsOutstatnding($helpdesks);

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsOutstandingTotalsView');
    $view->setDataSrc($templateData);
    $view->render();

  }
}
