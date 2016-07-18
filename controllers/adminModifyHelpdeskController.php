<?php

class adminModifyHelpdeskController {
  public function __construct()
  {
    //get ticket id from uri params.
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $id = $baseurl[3];
    //load required models
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
    $templateData->title = "Add Helpdesk";
    $templateData->details = "Please update the details for your changes.";
    // if not add ticket get ticket details
    if ($id !== "add") {
      $templateData->title = "Modify Helpdesk";
      $templateData->reportResults = $helpdeskModel->getHelpdeskById($id);
    }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('adminModifyHelpdeskView');
    $view->setDataSrc($templateData);
    $view->render();

  }
}
