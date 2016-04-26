<?php

class actionViewTicket {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //get ticket id from uri params.
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $ticketid = $baseurl[3];

    //create new models for required data
    $ticketModel = new ticketModel();
    $callreasonsModel = new callreasonsModel();
    $quickresponseModel = new quickresponseModel();
    $subscriptionModel = new subscriptionModel();

    //populate users ticket list
    $listdata = $ticketModel->getMyTickets($_SESSION['sAMAccountName'], 20);
    //populate tickets data
    $ticketDetails = $ticketModel->getTicketDetails($ticketid);
    $additionalDetails = $ticketModel->getAdditionalDetails($ticketid);
    $ticketDetails["subscribed"] = $subscriptionModel->amISuscribedToTicket($_SESSION['engineerId'], $ticketid);
    //populate call reasons for this tickets helpdeskid
    $callreasons = $callreasonsModel->getReasonsByHelpdeskId($ticketDetails["helpdesk"]);
    //populate quick responses
    $quickresponse = $quickresponseModel->getQuickResponseByHelpdeskId($ticketDetails["helpdesk"]);
    //update ticket views with user id and time stamp
    $ticketModel->logViewTicketById($ticketid, $_SESSION['sAMAccountName']);
    //render page
    require_once "views/ticketView.php";
  }
}
