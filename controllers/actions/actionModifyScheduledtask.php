<?php

class actionModifyScheduledtask {
  public function __construct()
  {
    //create new models for required data
    $changecontrolModel = new changecontrolModel();
    $helpdeskModel = new helpdeskModel();
    $pagedata = new stdClass();

    //Post Update Scheduledtask
      if ($_POST) {
        //modify Scheduledtask
        //TODO rainy day
      }

    //set report name
    $reportname = "Modify Scheduled Task";
    //set report title
    $pagedata->title = $reportname;
    $pagedata->details = "Please complete the form to add a scheduled task for the team.";

    //render template using $pagedata object
    require_once "views/modifyScheduledtask.php";

  }
}
