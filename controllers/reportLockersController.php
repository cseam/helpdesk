<?php

class reportLockersController {
  public function __construct()
  {
    //create new models for required data
    $helpdeskModel = new helpdeskModel();
    $lockersModel = new lockersModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Lockers";
    //get helpdesk details
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    //set page details
    $templateData->details = "";
    //if post update database
    if ($_POST) {
      //remove item from lockers
      $lockersModel->removeItemFromLockerById($_POST["callid"], $_SESSION['sAMAccountName']);
      //update page message
      $templateData->details = "<p>Item Returned - Ticket #".$_POST["callid"]." Updated</p><p>Ticket has been updated to show when the user collected the item, and who issued the item.</p>";
    }
    //populate report results for use in view
    $templateData->reportResults = $lockersModel->getLockersByHelpdesk($_SESSION['engineerHelpdesk']);

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsLockersView');
    $view->setDataSrc($templateData);
    $view->render();

  }
}
