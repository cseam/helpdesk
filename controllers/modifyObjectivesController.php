<?php

class modifyObjectivesController {
  public function __construct()
  {
    //get ticket id from uri params
    $baseurl = explode('/', $_SERVER['REQUEST_URI']);
    $objectiveid = $baseurl[3];
    //create new models for required data
    $objectivesModel = new objectivesModel();
    $engineerModel = new engineerModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //Post Update Objective
      if ($_POST) {
        $title = htmlspecialchars($_POST['title']);
        $datedue = $_POST['datedue'];
        $details = htmlspecialchars($_POST['details']);
        $objectivesModel->modifyObjectiveById($objectiveid, $title, $details, $datedue);
      }
      //get engineers list
      $templateData->engineers = $engineerModel->getListOfEngineersByHelpdeskId($_SESSION["engineerHelpdesk"]);
      //set report title
      $templateData->title = "Modify Performance Objective #".$objectiveid;
      $templateData->details = "Please modify the objective details as required.";
      $templateData->objectivedetails = $objectivesModel->getObjectiveById($objectiveid);

      //pass complete data and template to view engine and render
      $view = new Page();
      $view->setTemplate('modifyObjectives');
      $view->setDataSrc($templateData);
      $view->render();
  }
}
