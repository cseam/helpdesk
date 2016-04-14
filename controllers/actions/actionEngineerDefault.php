<?php

class actionEngineerDefault {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();

    $ticketModel = new ticketModel();
    //populate page content with oldest open ticket
    $ticketDetails = $ticketModel->getOldestTicketByEngineer($_SESSION['engineerId']);

    //render page
    require_once "views/engineerView.php";
  }
}
