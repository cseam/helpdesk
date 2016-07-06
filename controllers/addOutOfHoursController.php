<?php

class addOutOfHoursController {
  public function __construct()
  {
    //create new models for required data
    $outofhoursModel = new outofhoursModel();
    $helpdeskModel = new helpdeskModel();
    //create empty object to store data for template
    $templateData = new stdClass();

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

    //set report title
    $templateData->title = "Add Out Of Hours";
    $templateData->details = "Please complete the form to add an out of hours call for record.";

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('addOutofhours');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
