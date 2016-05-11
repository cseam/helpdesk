<?php

class actionUserProfile {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $pagedata = new stdClass();
    //set report name
    $pagedata->title = "My Profile";
    //set page details
    $pagedata->details = "//todo user profile here";
    // render page
    require_once "views/userView.php";
  }
}
