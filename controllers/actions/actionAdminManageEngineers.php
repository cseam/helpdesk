<?php

class actionAdminManageEngineers {
  public function __construct()
  {
    $ticketModel = new ticketModel();
    //populate page content
    $pagedata = new stdClass();
    $pagedata->title = "Manage Engineers";
    $pagedata->details = "//TODO create management controls";
    // render page
    require_once "views/adminView.php";

  }
}
