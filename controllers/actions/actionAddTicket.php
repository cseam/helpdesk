<?php

class actionAddTicket {
  public function __construct()
  {
    //create new models for required data
    $ticketModel = new ticketModel();
    $locationModel = new locationModel();
    $helpdeskModel = new helpdeskModel();
    //populate page content
    $pagedata = new stdClass();
    $pagedata->location = $locationModel->getListOfLocations();
    $pagedata->helpdesks = $helpdeskModel->getListOfHelpdeskWithoutDeactivated();
    // render page
    require_once "views/addticketView.php";
  }
}
