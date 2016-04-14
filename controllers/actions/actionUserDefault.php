<?php

class actionUserDefault {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $ticketModel = new ticketModel();
    $pagedata = new stdClass();
    //set report name
    $pagedata->title = "Recent Ticket Activity";
    $pagedata->reportResults = $ticketModel->getRecentActivityByOwner($_SESSION['sAMAccountName']);
    //set page details
    $pagedata->details = "The following tickets have recently been updated by an engineer, and require a response or feedback left.<br /><br /> To add a new ticket please click \"Add Ticket\" in the top right corner, to update a tickets details or leave feedback please click on the ticket title. ";
    // render page
    require_once "views/userView.php";
  }
}
