<?php

class actionViewTicket {
  public function __construct()
  {

    // populate my tickets list
      $ticketModel = new ticketModel();
      $listdata = $ticketModel->getMyTickets($_SESSION['sAMAccountName'], 20);

    // get ticket id from uri params
    // need to add some validation here for uri params and also some authentication checking to see if user has permission to see ticket also (if desired)
      $baseurl = explode('/',$_SERVER['REQUEST_URI']);
      $ticketDetails = $ticketModel->getTicketDetails($baseurl[3]);
      
    // render page
    require_once "views/ticketView.php";
  }

}
