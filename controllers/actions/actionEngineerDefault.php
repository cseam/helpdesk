<?php

class actionEngineerDefault {
  public function __construct()
  {
    // populate my assigned tickets list
      $ticketModel = new ticketModel();
      $listdata = $ticketModel->getMyOpenAssignedTickets($_SESSION['engineerId']);
    // populate page content with oldest open ticket
      $ticketDetails = $ticketModel->getOldestTicketByHelpdesk($_SESSION['engineerHelpdesk']);
    // render page
    require_once "views/engineerView.php";
  }

}
