<?php

class actionAdminModifyOutofhours {
  public function __construct()
  {
    //get ticket id from uri params.
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $id = $baseurl[3];
    //load required models
    $outofhoursModel = new outofhoursModel();
    $helpdeskModel = new helpdeskModel();
    //create page data objects
    $pagedata = new stdClass();
    //populate helpdesks
    $pagedata->helpdesks = $helpdeskModel->getListOfHelpdeskWithoutDeactivated();

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
    $pagedata->title = "Update Out of hours message";
    $pagedata->details = "Please update the details for your changes.";
    $pagedata->reportResults = $outofhoursModel->getOutOfHoursMessagesById($id);

    //render page
    require_once "views/adminModifyOutofhoursView.php";

  }
}
