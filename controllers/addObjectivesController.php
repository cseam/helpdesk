<?php

class addObjectivesController {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $objectivesModel = new objectivesModel();
    $engineerModel = new engineerModel();
    $pagedata = new stdClass();
    //Post Update Objective
      if ($_POST) {
        $assignto = htmlspecialchars($_POST['assignto']);
        $title = htmlspecialchars($_POST['title']);
        $datedue = $_POST['datedue'];
        $details = htmlspecialchars($_POST['details']);
        $objectivesModel->addObjective($assignto, $title, $datedue, $details);
      }
    //get engineers list
    $engineers = $engineerModel->getListOfEngineersByHelpdeskId($_SESSION["engineerHelpdesk"]);
    //set report name
    $reportname = "Add Performance Objective";
    //set report title
    $pagedata->title = $reportname;
    $pagedata->details = "Please complete the form to add a performance objective for an engineer.";
    //render template using $pagedata object
    require_once "views/addObjectives.php";
  }
}
