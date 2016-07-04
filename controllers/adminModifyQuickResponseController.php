<?php

class adminModifyQuickResponseController {
  public function __construct()
  {
    //get ticket id from uri params.
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $id = $baseurl[3];
    //load required models
    $quickresponseModel = new quickresponseModel();
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
      $object->quick_response = htmlspecialchars($_POST["quick_response"]);
      $object->helpdesk_id = htmlspecialchars($_POST["helpdesk_id"]);
      $quickresponseModel->upsertQuickResponse($object);
      // PRG Redirect
      header('Location: /admin/complete');
      exit;
    }
    $pagedata->title = "Add Quick Response";
    $pagedata->details = "Please update the details for your changes.";
    // if not add ticket get ticket details
    if ($id !== "add") {
      $pagedata->title = "Modify Quick Response";
      $pagedata->reportResults = $quickresponseModel->getQuickResponseById($id);
    }

    //render page
    require_once "views/adminModifyQuickResponseView.php";

  }
}
