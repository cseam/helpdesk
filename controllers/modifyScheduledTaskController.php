<?php

class modifyScheduledTaskController {
  public function __construct()
  {
    //create new models for required data
    $changecontrolModel = new changecontrolModel();
    $helpdeskModel = new helpdeskModel();
    //create empty object to store data for template
    $templateData = new stdClass();
    //Post Update Scheduledtask
      if ($_POST) {
        //modify Scheduledtask
        //TODO rainy day
      }
    //set report title
    $templateData->title = "Modify Scheduled Task";
    $templateData->details = "Please complete the form to add a scheduled task for the team.";

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('modifyScheduledtask');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
