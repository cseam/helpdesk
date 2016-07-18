<?php

class forwardTicketController {
  public function __construct()
  {
    //get ticket id from uri params
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $ticketid = $baseurl[3];
    //create new models for required data
    $ticketModel = new ticketModel();
    $helpdeskModel = new helpdeskModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //pass ticket id
    $templateData->ticketid = $ticketid;
    //populate helpdesks for dropdown
    $templateData->helpdesks = $helpdeskModel->getListOfHelpdesks();

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

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('forwardTicketView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
