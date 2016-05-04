<?php

class actionAdminComplete {
  public function __construct()
  {
    //populate page content
    $pagedata = new stdClass();
    $pagedata->title = "Thankyou";
    $pagedata->details = "Your change has been made to the database";
    // render page
    require_once "views/adminCompleteView.php";
  }

}
