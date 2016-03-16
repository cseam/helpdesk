<?php

class actionViewTicket {
  public function __construct()
  {
    //TODO add some validation here for uri params and also some authentication checking to see if user has permission to see ticket also (if desired)

    //get ticket id from uri params
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $ticketid = $baseurl[3];

    //create new models for required data
    $ticketModel = new ticketModel();
    $callreasonsModel = new callreasonsModel();

    //populate users ticket list
    $listdata = $ticketModel->getMyTickets($_SESSION['sAMAccountName'], 20);

    //populate tickets data
    $ticketDetails = $ticketModel->getTicketDetails($ticketid);
    $additionalDetails = $ticketModel->getAdditionalDetails($ticketid);
    //populate call reasons for this tickets helpdeskid
    $callreasons = $callreasonsModel->getReasonsByHelpdeskId($ticketDetails["helpdesk"]);
    //populate quick responses
    //TODO populate quick responses

    //update ticket views with user id and time stamp
    //TODO Function to log ticket views

    //render page
    require_once "views/ticketView.php";
  }
}
