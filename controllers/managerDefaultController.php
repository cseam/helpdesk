<?php

class managerDefaultController {
  public function __construct()
  {
    //create new models for required data.
    $ticketModel = new ticketModel();
    $feedbackModel = new feedbackModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Actionable tickets";
    //populate report results for use in view
    $templateData->escalatedResults = $ticketModel->getEscalatedTicketsByHelpdesk($_SESSION['engineerHelpdesk']);
    $templateData->unassignedResults = $ticketModel->getUnassignedTicketsByHelpdesk($_SESSION['engineerHelpdesk']);
    $templateData->stagnateResults = $ticketModel->getStagnateTicketsByHelpdesk($_SESSION['engineerHelpdesk']);
    $templateData->poorfeedbackResults = $feedbackModel->getPoorFeedback($_SESSION['engineerHelpdesk']);
    //set page details
    $templateData->details = "The following tickets have been highlighted as they require some form of manager action to proceed.";

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('managerView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
