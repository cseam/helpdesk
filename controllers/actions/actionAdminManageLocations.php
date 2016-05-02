<?php

class actionAdminManageLocations {
  public function __construct()
  {
    //load required models
    $locationModel = new locationModel();
    //populate page content
    $pagedata = new stdClass();
    $pagedata->title = "Manage Locations";
    $pagedata->details = "//TODO create management controls";
    $pagedata->listoflocations = $locationModel->getListOfLocations();
    // render page
    require_once "views/adminView.php";

  }
}
