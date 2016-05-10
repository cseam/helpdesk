<?php

class actionAdminModifySLA {
  public function __construct()
  {
    //get ticket id from uri params.
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $id = $baseurl[3];
    //load required models
    $slaModel = new servicelevelagreementModel();
    $helpdeskModel = new helpdeskModel();
    //create page data objects
    $pagedata = new stdClass();
    //populate helpdesks
    $pagedata->helpdesks = $helpdeskModel->getListOfHelpdeskWithoutDeactivated();
    // on post update
    if ($_POST) {
      // upsert locations
      $object = new stdClass();
      $object->id = empty($_POST["id"]) ? null : htmlspecialchars($_POST["id"]);
      $object->agreement = htmlspecialchars($_POST["agreement"]);
      $object->close_eta_days = htmlspecialchars($_POST["close_eta_days"]);
      $object->urgency = htmlspecialchars($_POST["urgency"]);
      $object->helpdesk = htmlspecialchars($_POST["helpdesk"]);
      $slaModel->upsertSLA($object);
      // PRG Redirect
      header('Location: /admin/complete');
      exit;
    }
    $pagedata->title = "Add SLA";
    $pagedata->details = "Please update the details for your location changes.";
    // if not add ticket get ticket details
    if ($id !== "add") {
      $pagedata->title = "Modify SLA";
      $pagedata->reportResults = $slaModel->getSLAById($id);
    }

    //render page
    require_once "views/adminModifySLAView.php";

  }
}
