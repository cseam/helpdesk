<?php

class actionAdminModifyLocation {
  public function __construct()
  {
    //get ticket id from uri params.
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $id = $baseurl[3];
    //load required models
    $locationModel = new locationModel();

    // on post update
    if ($_POST) {
      // upsert locations
      $locationobject = new stdClass();
      $locationobject->id = empty($_POST["id"]) ? null : htmlspecialchars($_POST["id"]);
      $locationobject->locationName = htmlspecialchars($_POST["locationName"]);
      $locationobject->iconlocation = htmlspecialchars($_POST["iconlocation"]);
      $locationobject->shorthand = htmlspecialchars($_POST["shorthand"]);
      $locationModel->upsertLocation($locationobject);
      // PRG Redirect
      header('Location: /admin/complete');
      exit;
    }

    $pagedata->title = "Add Location";
    $pagedata->details = "Please add the details for your location changes";
    // if not add ticket get ticket details
    if ($id !== "add") {
      $pagedata = new stdClass();
      $pagedata->title = "Modify Location";
      $pagedata->details = "Please modify the details for your location change.";
      $pagedata->reportResults = $locationModel->getLocationById($id);
    }

    //render page
    require_once "views/adminModifyLocationView.php";

  }
}
