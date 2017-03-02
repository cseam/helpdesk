<?php

class modifyScheduledTaskController {
  public function __construct()
  {
    //get ticket id from uri params.
    $baseurl = explode('/', $_SERVER['REQUEST_URI']);
    $taskid = $baseurl[3];
    //create new models for required data
    $scheduledtaskModel = new scheduledtaskModel();
    $helpdeskModel = new helpdeskModel();
    $engineerModel = new engineerModel();
    //create empty object to store data for template
    $templateData = new stdClass();
    //Post Update Scheduledtask
      if ($_POST) {
        //prep update Scheduledtask
        $updatedTask = new stdClass();
        $updatedTask->callid = htmlspecialchars($_POST['callid']);
        $updatedTask->enabled = htmlspecialchars($_POST['enabled']);
        $updatedTask->title = htmlspecialchars($_POST['title']);
        $updatedTask->details = "<div class=original>" . htmlspecialchars($_POST['details']) . "</div>";
        if ($_POST['assigned'] == 'DONT') {
          $updatedTask->assigned = NULL;
        } elseif ($_POST['assigned'] == 'AUTO') {
          $updatedTask->assigned = -1;
        } else {
          $updatedTask->assigned = htmlspecialchars($_POST['assigned']);
        };
        $updatedTask->reoccurance = htmlspecialchars($_POST['reoccurance']);
        $updatedTask->starton = htmlspecialchars($_POST['starton']);
        if ($_POST['reoccurance'] == 'spring') {
          $updatedTask->reoccurance = 'yearly';
          $updatedTask->starton = date("Y").'/01/15';
        }
        if ($_POST['reoccurance'] == 'summer') {
          $updatedTask->reoccurance = 'yearly';
          $updatedTask->starton = date("Y").'/04/15';
        }
        if ($_POST['reoccurance'] == 'winter') {
          $updatedTask->reoccurance = 'yearly';
          $updatedTask->starton = date("Y").'/09/15';
        }
        // update task
        $scheduledtaskModel->updateTaskWithObject($updatedTask);
      }
    //set report title
    $templateData->title = "Modify Scheduled Task";
    $templateData->details = "Please update your scheduled task, if you need to modify fields not displayed you need to recreate a new Scheduled Task.";
    //get task details
    //populate form dropdowns
    $templateData->engineers = $engineerModel->getListOfEngineersByHelpdeskId($_SESSION['engineerHelpdesk']);
    $templateData->taskDetails = $scheduledtaskModel->getTaskDetailsById($taskid);

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('modifyScheduledtask');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
