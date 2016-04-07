<?php

class actionViewObjectives {
  public function __construct()
  {
    //get ticket id from uri params
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $objectiveid = $baseurl[3];

    //create new models for required data
    $helpdeskModel = new helpdeskModel();
    $objectivesModel = new objectivesModel();
    $pagedata = new stdClass();

    //set report name
    $reportname = "Performance Objective #".$objectiveid;
    //set report title
    $pagedata->title = $reportname;

    //populate report results for use in view
    $pagedata->reportResults = $objectivesModel->getObjectiveById($objectiveid);

    //render template using $pagedata object
    require_once "views/ObjectivesView.php";
  }
}
