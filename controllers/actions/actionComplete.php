<?php

class actionComplete {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //populate page content
    $pagedata = new stdClass();
    $pagedata->title = "Thankyou";
    $pagedata->details = "Your change has been made to the database";
    // render page
    require_once "views/completeView.php";
  }

}
