<?php

class engineerDefaultController {
  public function __construct()
  {
    //create new models required
    $ticketModel = new ticketModel();
    $callreasonsModel = new callreasonsModel();
    $quickresponseModel = new quickresponseModel();
    $engineersModel = new engineerModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //populate page content with oldest open ticket
    $templateData->ticketDetails = $ticketModel->getOldestTicketByEngineer($_SESSION['engineerId']);
    $templateData->ticketUpdates = $ticketModel->getTicketUpdatesByCallId($templateData->ticketDetails["callid"]);
    $templateData->additionalDetails = $ticketModel->getAdditionalDetails($templateData->ticketDetails["callid"]);
    //populate call reasons for this tickets helpdeskid
    $templateData->callreasons = $callreasonsModel->getReasonsByHelpdeskId($templateData->ticketDetails["helpdesk"]);
    //populate quick responses
    $templateData->quickresponse = $quickresponseModel->getQuickResponseByHelpdeskId($templateData->ticketDetails["helpdesk"]);
    //get engineers for helpdesk
    $templateData->engineersList = $engineersModel->getListOfEngineersByHelpdeskId($templateData->ticketDetails["helpdesk"]);

    //update ticket views with user id and time stamp
    $ticketModel->logViewTicketById($templateData->ticketDetails["callid"], $_SESSION['sAMAccountName']);

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('engineerView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
