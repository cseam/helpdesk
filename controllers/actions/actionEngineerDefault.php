<?php

class actionEngineerDefault {
  public function __construct()
  {
    //populate engineer reports various lists
    $ticketModel = new ticketModel();
    $objectivesModel = new objectivesModel();
    $listdata = $ticketModel->getMyOpenAssignedTickets($_SESSION['engineerId']);
    $deptdata = $ticketModel->getOpenTicketsByHelpdesk($_SESSION['engineerHelpdesk']);
    $objdata = $objectivesModel->getObjectivesByEngineerId($_SESSION['engineerId']);

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
