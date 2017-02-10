<?php

class adminModifyLocationController {
  public function __construct()
  {
    //get ticket id from uri params.
    $baseurl = explode('/', $_SERVER['REQUEST_URI']);
    $id = $baseurl[3];
    //load required models
    $locationModel = new locationModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    // on post update
    if ($_POST) {
      // upsert locations
      $locationobject = new stdClass();
      $locationobject->id = empty($_POST["id"]) ? null : htmlspecialchars($_POST["id"]);
      $locationobject->locationName = htmlspecialchars($_POST["locationName"]);
      $locationobject->iconlocation = htmlspecialchars($_POST["iconlocation"]);
      $locationobject->shorthand = htmlspecialchars($_POST["shorthand"]);
      $locationobject->optiongroup = htmlspecialchars($_POST["optiongroup"]);
      $locationModel->upsertLocation($locationobject);
      // PRG Redirect
      header('Location: /admin/complete');
      exit;
    }

    $templateData->title = "Add Location";
    $templateData->details = "Please update the details for your location changes.";
    // if not add ticket get ticket details
    if ($id !== "add") {
      $templateData->title = "Modify Location";
      $templateData->reportResults = $locationModel->getLocationById($id);
    }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('adminModifyLocationView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
