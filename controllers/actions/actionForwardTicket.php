<?php

class actionForwardTicket {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //get ticket id from uri params
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $ticketid = $baseurl[3];
    //create new models for required data
    $ticketModel = new ticketModel();
    $helpdeskModel = new helpdeskModel();
    //populate helpdesks for dropdown
    $helpdesks = $helpdeskModel->getListOfHelpdesks();
    if ($_POST) {
      //update ticket
      $updatemessage = "Ticket forwarded by " . $_SESSION["sAMAccountName"] . " for the following reason: " . $_POST["reason"];
      $ticketModel->updateTicketDetailsById($ticketid, "open", $_SESSION["sAMAccountName"] , $updatemessage);
      //change helpdesk
      $ticketModel->updateTicketHelpdeskById($ticketid, $_POST["fwdhelpdesk"]);
      //remove engineer assigned
      $ticketModel->updateTicketRemoveAssignmentById($ticketid);
      //set ticket status to open
      $ticketModel->updateTicketStatusById($ticketid, 1);
      //reroute to ticket
      header('Location: /ticket/view/'.$ticketid);
      exit;
    }
    //render page
    require_once "views/forwardTicketView.php";
  }
}
