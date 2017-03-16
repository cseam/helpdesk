<?php

class viewTicketController {
  public function __construct()
  {
    //get ticket id from uri params.
    $baseurl = explode('/', $_SERVER['REQUEST_URI']);
    $ticketid = $baseurl[3];
    //create new models for required data
    $ticketModel = new ticketModel();
    $callreasonsModel = new callreasonsModel();
    $quickresponseModel = new quickresponseModel();
    $subscriptionModel = new subscriptionModel();
    $engineersModel = new engineerModel();
    //create empty object to store data for template
    $templateData = new stdClass();
    $view = new Page();
    //pass details for template
    $templateData->ticketid = $ticketid;
    //populate users ticket list
    $templateData->listdata = $ticketModel->getMyTickets($_SESSION['sAMAccountName'], 20);
    //populate tickets data
    $templateData->ticketDetails = $ticketModel->getTicketDetails($ticketid);
    $templateData->ticketUpdates = $ticketModel->getTicketUpdatesByCallId($ticketid);
    $templateData->additionalDetails = $ticketModel->getAdditionalDetails($ticketid);
    $templateData->ticketDetails["subscribed"] = $subscriptionModel->amISuscribedToTicket($_SESSION['engineerId'], $ticketid);
    //populate est ticket time total
    $esttimetotal = 0;
    foreach ($templateData->ticketUpdates as &$update) { $esttimetotal += $update["esttime"]; }
    $templateData->ticketDetails["esttime"] = $esttimetotal.' min';
    //check user has rights to view ticket engineers can see any ticket
    if ($_SESSION['engineerLevel'] == '0' & strtolower($_SESSION['sAMAccountName']) != strtolower($templateData->ticketDetails["owner"]) ) {
      $view->setTemplate('nopermissionView');
      $view->setDataSrc(null);
      $view->render();
      exit;
    }
    //populate call reasons for this tickets helpdeskid
    $templateData->callreasons = $callreasonsModel->getReasonsByHelpdeskId($templateData->ticketDetails["helpdesk"]);
    //populate quick responses
    $templateData->quickresponse = $quickresponseModel->getQuickResponseByHelpdeskId($templateData->ticketDetails["helpdesk"]);
    //get engineers for helpdesk
    $templateData->engineersList = $engineersModel->getListOfEngineersByHelpdeskId($templateData->ticketDetails["helpdesk"]);
    //update ticket views with user id and time stamp
    $ticketModel->logViewTicketById($ticketid, $_SESSION['sAMAccountName']);
    //pass complete data and template to view engine and render
    $view->setTemplate('ticketView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
