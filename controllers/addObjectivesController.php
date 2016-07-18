<?php

class addObjectivesController {
  public function __construct()
  {
    //create new models for required data
    $objectivesModel = new objectivesModel();
    $engineerModel = new engineerModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //Post Update Objective
      if ($_POST) {
        $assignto = htmlspecialchars($_POST['assignto']);
        $title = htmlspecialchars($_POST['title']);
        $datedue = $_POST['datedue'];
        $details = htmlspecialchars($_POST['details']);
        $objectivesModel->addObjective($assignto, $title, $datedue, $details);
      }
    //get engineers list
    $templateData->engineers = $engineerModel->getListOfEngineersByHelpdeskId($_SESSION["engineerHelpdesk"]);
    //set report title
    $templateData->title = "Add Performance Objective";
    $templateData->details = "Please complete the form to add a performance objective for an engineer.";

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('addObjectives');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
