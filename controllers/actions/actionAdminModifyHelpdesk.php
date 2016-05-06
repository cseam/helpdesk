<?php

class actionAdminModifyHelpdesk {
  public function __construct()
  {
    //get ticket id from uri params.
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $id = $baseurl[3];
    //load required models
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
      $object->helpdesk_name = htmlspecialchars($_POST["helpdesk_name"]);
      $object->description = htmlspecialchars($_POST["description"]);
      $object->deactivate = htmlspecialchars($_POST["deactivate"]);
      $object->auto_assign = htmlspecialchars($_POST["auto_assign"]);
      $object->email_on_newticket = htmlspecialchars($_POST["email_on_newticket"]);
      $helpdeskModel->upsertHelpdesk($object);
      // PRG Redirect
      header('Location: /admin/complete');
      exit;
    }
    $pagedata->title = "Add Helpdesk";
    $pagedata->details = "Please update the details for your changes.";
    // if not add ticket get ticket details
    if ($id !== "add") {
      $pagedata->title = "Modify Helpdesk";
      $pagedata->reportResults = $helpdeskModel->getHelpdeskById($id);
    }

    //render page
    require_once "views/adminModifyHelpdeskView.php";

  }
}
