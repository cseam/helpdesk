<?php

class actionAdminManageOutofhours {
  public function __construct()
  {
    $ticketModel = new ticketModel();
    //populate page content
    $pagedata = new stdClass();
    $pagedata->title = "Manage Out of Hours Messages";
    $pagedata->details = "//TODO create management controls";
    // render page
    require_once "views/adminView.php";

  }
}
