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

    //create empty object to store data for template
    $templateData = new stdClass();
    //populate helpdesks
    $templateData->helpdesks = $helpdeskModel->getListOfHelpdeskWithoutDeactivated();

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
    $templateData->title = "Add Quick Response";
    $templateData->details = "Please update the details for your changes.";
    // if not add ticket get ticket details
    if ($id !== "add") {
      $templateData->title = "Modify Quick Response";
      $templateData->reportResults = $quickresponseModel->getQuickResponseById($id);
    }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('adminModifyQuickResponseView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
