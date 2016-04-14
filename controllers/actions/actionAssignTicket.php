<?php

class actionAssignTicket {
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
    $engineerModel = new engineerModel();
    //get ticket details
    $ticketDetails = $ticketModel->getTicketDetails($ticketid);
    //populate engineers for dropdown
    $engineers = $engineerModel->getListOfEngineersByHelpdeskId($ticketDetails["helpdesk"]);
    if ($_POST) {
      //update ticket
      $updatemessage = "Ticket Assigned to " . $engineerModel->getEngineerFriendlyNameById($_POST["assignto"]) . " for the following reason: " . $_POST["reason"];
      $ticketModel->updateTicketDetailsById($ticketid, "open", $_SESSION["sAMAccountName"] , $updatemessage);
      //change assignment
      $ticketModel->updateTicketAssignmentById($ticketid, $_POST["assignto"]);
      //reroute to ticket
      header('Location: /ticket/view/'.$ticketid);
      exit;
    }
    //render page
    require_once "views/assignTicketView.php";
  }
}
