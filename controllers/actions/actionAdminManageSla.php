<?php

class actionAdminManageSla {
  public function __construct()
  {
    $ticketModel = new ticketModel();
    //populate page content
    $pagedata = new stdClass();
    $pagedata->title = "Manage Service Level Agreements";
    $pagedata->details = "//TODO create management controls";
    // render page
    require_once "views/adminView.php";
  }
}
