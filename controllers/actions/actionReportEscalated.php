<?php

class actionReportEscalated {
  public function __construct()
  {
    // Dont need to populate $listdata as fixed partial in manager view
    // Dont need to populate $stats as fixed partial in manager view

    $pagedata = new stdClass();
    $pagedata->title = "Escalated Tickets";

    // populate report
    $ticketModel = new ticketModel();
    $pagedata->reportResults = $ticketModel->getEscalatedTicketsByHelpdesk($_SESSION['engineerHelpdesk']);

    // render page
    require_once "views/managerView.php";
  }

}
