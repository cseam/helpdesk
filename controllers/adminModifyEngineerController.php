<?php

class adminModifyEngineerController {
  public function __construct()
  {
    //get ticket id from uri params.
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $id = $baseurl[3];
    //load required models
    $helpdeskModel = new helpdeskModel();
    $engineerModel = new engineerModel();
    //create page data objects
    $pagedata = new stdClass();
    //populate helpdesks
    $pagedata->helpdesks = $helpdeskModel->getListOfHelpdeskWithoutDeactivated();

    // on post update
    if ($_POST) {
      // upsert locations
      $object = new stdClass();
      $object->id = empty($_POST["id"]) ? null : htmlspecialchars($_POST["id"]);
      $object->engineerName = htmlspecialchars($_POST["engineerName"]);
      $object->engineerEmail = htmlspecialchars($_POST["engineerEmail"]);
      $object->availableDays = htmlspecialchars($_POST["availableDays"]);
      $object->sAMAccountName = htmlspecialchars($_POST["sAMAccountName"]);
      $object->engineerLevel = htmlspecialchars($_POST["engineerLevel"]);
      $object->helpdesk = htmlspecialchars($_POST["helpdesk"]);
      $object->superuser = htmlspecialchars($_POST["superuser"]);
      $object->disabled = htmlspecialchars($_POST["disabled"]);
      $object->localLoginHash = htmlspecialchars($_POST["localLoginHash"]);
      $engineerModel->upsertEngineer($object);
      // PRG Redirect
      header('Location: /admin/complete');
      exit;
    }
    $pagedata->title = "Add Engineer";
    $pagedata->details = "Please update the details for your changes.";
    // if not add ticket get ticket details
    if ($id !== "add") {
      $pagedata->title = "Modify Engineer";
      $pagedata->reportResults = $engineerModel->getEngineerById($id);
    }

    //render page
    require_once "views/adminModifyEngineerView.php";

  }
}
