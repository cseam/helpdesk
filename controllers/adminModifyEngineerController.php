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

    //create empty object to store data for template
    $templateData = new stdClass();
    //populate helpdesks
    $templateData->helpdesks = $helpdeskModel->getListOfHelpdeskWithoutDeactivated();

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
    $templateData->title = "Add Engineer";
    $templateData->details = "Please update the details for your changes.";
    // if not add ticket get ticket details
    if ($id !== "add") {
      $templateData->title = "Modify Engineer";
      $templateData->reportResults = $engineerModel->getEngineerById($id);
    }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('adminModifyEngineerView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
