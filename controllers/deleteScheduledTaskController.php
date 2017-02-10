<?php

class deleteScheduledTaskController {
  public function __construct()
  {
    //get ticket id from uri params
    $baseurl = explode('/', $_SERVER['REQUEST_URI']);
    $taskid = $baseurl[3];
    //create new models for required data
    $scheduledtaskModel = new scheduledtaskModel();
    $helpdeskModel = new helpdeskModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //Post Update Scheduledtask
      if ($taskid) {
        //delete Scheduledtask
        //this needs refactorying url could be changed to remove items (CLOWN FIESTA) also at least prompt user dont just instantly remove
        $taskid = htmlspecialchars($taskid);
        $scheduledtaskModel->removeScheduledTaskById($taskid);
      }
    //set report title
    $templateData->title = "Scheduled Task Deleted";
    $templateData->details = "Your scheduled task has now been deleted.";

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('deleteScheduledtask');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
