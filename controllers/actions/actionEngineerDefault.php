<?php

class actionEngineerDefault {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();

    $ticketModel = new ticketModel();
    $callreasonsModel = new callreasonsModel();
    $quickresponseModel = new quickresponseModel();
    //populate page content with oldest open ticket
    $ticketDetails = $ticketModel->getOldestTicketByEngineer($_SESSION['engineerId']);
    $additionalDetails = $ticketModel->getAdditionalDetails($ticketDetails["callid"]);
    //populate call reasons for this tickets helpdeskid
    $callreasons = $callreasonsModel->getReasonsByHelpdeskId($ticketDetails["helpdesk"]);
    //populate quick responses
    $quickresponse = $quickresponseModel->getQuickResponseByHelpdeskId($ticketDetails["helpdesk"]);
    //update ticket views with user id and time stamp
    $ticketModel->logViewTicketById($ticketDetails["callid"], $_SESSION['sAMAccountName']);
    //render page
    require_once "views/engineerView.php";
  }
}
