<?php

class actionEngineerDefault {
  public function __construct()
  {
    //populate my assigned tickets list
    $ticketModel = new ticketModel();
    $listdata = $ticketModel->getMyOpenAssignedTickets($_SESSION['engineerId']);
    //populate page content with oldest open ticket
    $ticketDetails = $ticketModel->getOldestTicketByEngineer($_SESSION['engineerId']);
    //populate stats object for graphs
    $statsModel = new statsModel();
    $stats = array();
    $stats = array_merge($stats, $statsModel->countAllTicketsByEngineerIdLastWeek($_SESSION['engineerId']));
    $stats = array_merge($stats, $statsModel->countClosedByEngineerIdLastWeek($_SESSION['engineerId']));
    $stats = array_merge($stats, $statsModel->countEngineerTotalsLastWeek($_SESSION['engineerId']));

    //render page
    require_once "views/engineerView.php";
  }
}
