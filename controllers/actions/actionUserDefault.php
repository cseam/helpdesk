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
    $pagedata->details = "The following tickets have had recent activity, please check an engineer has not requested a response or feedback left.<br />Or you can <a href=\"/ticket/add/\" class=\"hyperbutton\">Create a new ticket</a>";
    // render page
    require_once "views/userView.php";
  }
}
