<?php

class actionEngineerDefault {
  public function __construct()
  {
    // populate my assigned tickets list
      $ticketModel = new ticketModel();
      $listdata = $ticketModel->getMyOpenAssignedTickets($_SESSION['engineerId']);
    // populate page content with oldest open ticket
      $ticketDetails = $ticketModel->getOldestTicketByHelpdesk($_SESSION['engineerHelpdesk']);
    // populate stats object for graphs
      $statsModel = new statsModel();
      $stats = @array();
      $stats = array_merge($stats, $statsModel->countAllTickets());
      $stats = array_merge($stats, $statsModel->countTicketsByHelpdesk($_SESSION['engineerHelpdesk']));
    // render page
    require_once "views/engineerView.php";
  }

}
