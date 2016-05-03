<?php

class actionAdminManageLocations {
  public function __construct()
  {
    //load required models
    $locationModel = new locationModel();
    //populate page content
    $pagedata = new stdClass();
    $pagedata->title = "Manage Locations";
    $pagedata->details = "Locations available for users to select when adding a new ticket to " . CODENAME;

    $pagedata->listoflocations = $locationModel->getListOfLocations();

    // render page
    require_once "views/adminManageLocationsView.php";

  }
}
