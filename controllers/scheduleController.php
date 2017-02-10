<?php

class scheduleController {
  public function __construct()
  {
    //get ticket id from uri params
    $baseurl = explode('/', $_SERVER['REQUEST_URI']);
    $ticketid = $baseurl[3];
    //create empty object to store data for template
    $templateData = new stdClass();
    $templateData->ticketid = $ticketid;
    //create new models for required data
    $ticketModel = new ticketModel();
      if ($_POST) {
        //get datetime from form
        $opened = checkdate(substr($_POST["date-for"], 5, 2), substr($_POST["date-for"], 8, 2), substr($_POST["date-for"], 0, 4)) ? substr($_POST["date-for"], 0, 10) : substr(date("c"), 0, 10);
        //update ticket
        $updatemessage = "Ticket has been scheduled for a future time by ".$_SESSION["sAMAccountName"].". <br/>This ticket will automatically reopen on ".$opened.". <br/>Scheduled for the following reason: ".$_POST["reason"];
        $ticketModel->updateTicketDetailsById($ticketid, "scheduled", $_SESSION["sAMAccountName"], $updatemessage);
        //set ticket status to open
        $ticketModel->updateTicketStatusById($ticketid, 6);
        //update open time to new scheduled time
        $ticketModel->updateTicketOpenById($ticketid, $opened);
        //reroute to ticket
        header('Location: /ticket/view/'.$ticketid);
        exit;
      }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('scheduleTicketView');
    $view->setDataSrc($templateData);
    $view->render();
  }

}
