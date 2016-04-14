<?php

class actionAddOutofhours {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $outofhoursModel = new outofhoursModel();
    $helpdeskModel = new helpdeskModel();
    $pagedata = new stdClass();
    //Post Update Objective
      if ($_POST) {
        //create out of hours
        $name = htmlspecialchars($_POST['name']);
        $dateofcall = htmlspecialchars($_POST['dateofcall']);
        $timeofcall = htmlspecialchars($_POST['timeofcall']);
        $calloutby = htmlspecialchars($_POST['calloutby']);
        $problem = htmlspecialchars($_POST['problem']);
        $previsit = htmlspecialchars($_POST['previsit']);
        $timeonsite = htmlspecialchars($_POST['timeonsite']);
        $timeleftsite = htmlspecialchars($_POST['timeleftsite']);
        $locations = htmlspecialchars($_POST['locations']);
        $resolution = htmlspecialchars($_POST['resolution']);
        $outofhoursModel->addOutofhours($name, $dateofcall, $timeofcall, $calloutby, $problem, $previsit, $timeonsite, $timeleftsite, $locations, $resolution);
      }
    //set report name
    $reportname = "Add Out Of Hours";
    //set report title
    $pagedata->title = $reportname;
    $pagedata->details = "Please complete the form to add an out of hours call for record.";
    //render template using $pagedata object
    require_once "views/addOutofhours.php";
  }
}
