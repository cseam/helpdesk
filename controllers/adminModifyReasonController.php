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

    //create empty object to store data for template
    $templateData = new stdClass();
    //populate helpdesks
    $templateData->helpdesks = $helpdeskModel->getListOfHelpdeskWithoutDeactivated();

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
    $templateData->title = "Add Call Reason";
    $templateData->details = "Please update the details for your changes.";
    // if not add ticket get ticket details
    if ($id !== "add") {
      $templateData->title = "Modify Call Reason";
      $templateData->reportResults = $reasonModel->getReasonById($id);
    }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('adminModifyReasonView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
