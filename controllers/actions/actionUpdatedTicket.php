<?php

class actionUpdatedTicket {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    $pagedata = $_SESSION['pagedata'];
    // render page
    require_once "views/updateTicketView.php";
  }

}
