<?php

class actionViewTicket {
  public function __construct()
  {
    //get params
    //TODO add some validation here for uri params and also some authentication checking to see if user has permission to see ticket also (if desired)
    //get ticket id from uri params
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $ticketid = $baseurl[3];
    //populate tickets data
    $ticketModel = new ticketModel();
    $listdata = $ticketModel->getMyTickets($_SESSION['sAMAccountName'], 20);
    $ticketDetails = $ticketModel->getTicketDetails($ticketid);
    $additionalDetails = $ticketModel->getAdditionalDetails($ticketid);
    //render page
    require_once "views/ticketView.php";
  }
}
