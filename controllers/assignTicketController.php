<?php

class assignTicketController {
  public function __construct()
  {
    //get ticket id from uri params
    $baseurl = explode('/', $_SERVER['REQUEST_URI']);
    $ticketid = $baseurl[3];
    //create new models for required data
    $ticketModel = new ticketModel();
    $helpdeskModel = new helpdeskModel();
    $engineerModel = new engineerModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //pass ticket id
    $templateData->ticketid = $ticketid;
    //get ticket details
    $templateData->ticketDetails = $ticketModel->getTicketDetails($ticketid);
    //populate engineers for dropdown
    $templateData->engineers = $engineerModel->getListOfEngineersByHelpdeskId2($_SESSION['engineerHelpdesk']);

    if ($_POST) {
      //update ticket
      $updatemessage = "Ticket Assigned to ".$engineerModel->getEngineerFriendlyNameById($_POST["assignto"])." for the following reason: ".$_POST["reason"];
      $ticketModel->updateTicketDetailsById($ticketid, "open", $_SESSION["sAMAccountName"], $updatemessage);
      //change assignment
      $ticketModel->updateTicketAssignmentById($ticketid, $_POST["assignto"]);
      //reroute to ticket
      header('Location: /ticket/view/'.$ticketid);
      exit;
    }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('assignTicketView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
