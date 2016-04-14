<?php

class actionDeleteScheduledtask {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //get ticket id from uri params
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $taskid = $baseurl[3];
    //create new models for required data
    $scheduledtaskModel = new scheduledtaskModel();
    $helpdeskModel = new helpdeskModel();
    $pagedata = new stdClass();
    //Post Update Scheduledtask
      if ($taskid) {
        //delete Scheduledtask
        //this needs refactorying url could be changed to remove items (CLOWN FIESTA) also at least prompt user dont just instantly remove
        $taskid = htmlspecialchars($taskid);
        $scheduledtaskModel->removeScheduledTaskById($taskid);
      }
    //set report name
    $reportname = "Scheduled Task Deleted";
    //set report title
    $pagedata->title = $reportname;
    $pagedata->details = "Your scheduled task has now been deleted.";
    //render template using $pagedata object
    require_once "views/deleteScheduledtask.php";
  }
}
