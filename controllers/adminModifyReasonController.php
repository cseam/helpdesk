<?php

class adminModifyReasonController {
  public function __construct()
  {
    //get ticket id from uri params.
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $id = $baseurl[3];
    //load required models
    $reasonModel = new callreasonsModel();
    $helpdeskModel = new helpdeskModel();
    //create page data objects
    $pagedata = new stdClass();
    //populate helpdesks
    $pagedata->helpdesks = $helpdeskModel->getListOfHelpdeskWithoutDeactivated();

    // on post update
    if ($_POST) {
      // upsert locations
      $reasonobject = new stdClass();
      $reasonobject->id = empty($_POST["id"]) ? null : htmlspecialchars($_POST["id"]);
      $reasonobject->reason_name = htmlspecialchars($_POST["reason_name"]);
      $reasonobject->helpdesk_id = htmlspecialchars($_POST["helpdesk_id"]);
      $reasonModel->upsertReason($reasonobject);
      // PRG Redirect
      header('Location: /admin/complete');
      exit;
    }
    $pagedata->title = "Add Call Reason";
    $pagedata->details = "Please update the details for your changes.";
    // if not add ticket get ticket details
    if ($id !== "add") {
      $pagedata->title = "Modify Call Reason";
      $pagedata->reportResults = $reasonModel->getReasonById($id);
    }

    //render page
    require_once "views/adminModifyReasonView.php";

  }
}
