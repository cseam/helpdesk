<?php

class adminModifySLAController {
  public function __construct()
  {
    //get ticket id from uri params.
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $id = $baseurl[3];
    //load required models
    $slaModel = new servicelevelagreementModel();
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
      $object->agreement = htmlspecialchars($_POST["agreement"]);
      $object->close_eta_days = htmlspecialchars($_POST["close_eta_days"]);
      $object->urgency = htmlspecialchars($_POST["urgency"]);
      $object->helpdesk = htmlspecialchars($_POST["helpdesk"]);
      $slaModel->upsertSLA($object);
      // PRG Redirect
      header('Location: /admin/complete');
      exit;
    }
    $templateData->title = "Add SLA";
    $templateData->details = "Please update the details for your location changes.";
    // if not add ticket get ticket details
    if ($id !== "add") {
      $templateData->title = "Modify SLA";
      $templateData->reportResults = $slaModel->getSLAById($id);
    }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('adminModifySLAView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
