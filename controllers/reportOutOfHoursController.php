<?php

class reportOutOfHoursController {
  public function __construct()
  {
    //create new models for required data
    $helpdeskModel = new helpdeskModel();
    $outofhoursModel = new outofhoursModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //Post Update Objective
      if ($_POST) {
        SWITCH ($_POST["button_value"]) {
          CASE "add":
            // reroute to add form
            header('Location: /outofhours/add');
            exit;
          break;
          CASE "update":
            //TODO should change control be updatable?
          break;
          CASE "modify":
            //TODO should change control be modifiable?
          break;
          CASE "delete":
            //TODO should engineers be able to delete change controls?
          break;
        }
      }

    //set report title
    $templateData->title = "Out of hours";
    //populate report results for use in view
    $templateData->reportResults = $outofhoursModel->getOutOfHours(1);
    //get helpdesk details
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    //set page details
    $templateData->details = sizeof($templateData->reportResults)." ".$templateData->title." for ".$helpdeskdetails["helpdesk_name"]." helpdesk.";

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsOutOfHoursView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
