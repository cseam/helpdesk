<?php

class adminModifyOutOfHoursController {
  public function __construct()
  {
    //get ticket id from uri params.
    $baseurl = explode('/', $_SERVER['REQUEST_URI']);
    $id = $baseurl[3];
    //load required models
    $outofhoursModel = new outofhoursModel();
    $helpdeskModel = new helpdeskModel();

    //create empty object to store data for template
    $templateData = new stdClass();
    //populate helpdesks
    $templateData->helpdesks = $helpdeskModel->getListOfHelpdeskWithoutDeactivated();

    // on post update
    if ($_POST) {
      // upsert locations
      $outofhoursobject = new stdClass();
      $outofhoursobject->id = htmlspecialchars($_POST["id"]);
      $outofhoursobject->message = htmlspecialchars($_POST["message"]);
      $outofhoursobject->end_of_day = htmlspecialchars($_POST["end_of_day"]);
      $outofhoursobject->helpdesk = htmlspecialchars($_POST["helpdesk"]);
      $outofhoursModel->updateOutOfHoursMessages($outofhoursobject);
      // PRG Redirect
      header('Location: /admin/complete');
      exit;
    }
    $templateData->title = "Update Out of hours message";
    $templateData->details = "Please update the details for your changes.";
    $templateData->reportResults = $outofhoursModel->getOutOfHoursMessagesById($id);

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('adminModifyOutofhoursView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
