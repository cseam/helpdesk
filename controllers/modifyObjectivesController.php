<?php

class modifyObjectivesController {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //get ticket id from uri params
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $objectiveid = $baseurl[3];
    //create new models for required data
    $objectivesModel = new objectivesModel();
    $engineerModel = new engineerModel();
    $pagedata = new stdClass();
    //Post Update Objective
      if ($_POST) {
        $title = htmlspecialchars($_POST['title']);
        $datedue = $_POST['datedue'];
        $details = htmlspecialchars($_POST['details']);
        $objectivesModel->modifyObjectiveById($objectiveid, $title, $details, $datedue);
      }
      //get engineers list
      $engineers = $engineerModel->getListOfEngineersByHelpdeskId($_SESSION["engineerHelpdesk"]);
      //set report name
      $reportname = "Modify Performance Objective #". $objectiveid;
      //set report title
      $pagedata->title = $reportname;
      $pagedata->details = "Please modify the objective details as required.";
      $pagedata->objectivedetails = $objectivesModel->getObjectiveById($objectiveid);
      //render template using $pagedata object
      require_once "views/modifyObjectives.php";
  }
}
