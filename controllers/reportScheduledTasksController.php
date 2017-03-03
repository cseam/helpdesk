<?php

class reportScheduledTasksController {
  public function __construct()
  {
    //create new models for required data
    $helpdeskModel = new helpdeskModel();
    $scheduledtaskModel = new scheduledtaskModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //On post reroute
      if ($_POST) {
        $callid = isset($_POST['callid']) ? $_POST['callid'] : null;
        $switch = (isset($_POST["button_modify_value"]) ? $_POST["button_modify_value"] : $_POST["button_value"]);
        SWITCH ($switch) {
          CASE "add":
            // reroute to add form
            header('Location: /scheduledtask/add');
            exit;
          CASE "enableall":
            // enable all tasks for this helpdesk
            $scheduledtaskModel->enableAllScheduledTasksByHelpdesk($_SESSION['engineerHelpdesk']);
          break;
          CASE "disableall":
            // disable all tasks for this helpdesk
            $scheduledtaskModel->disableAllScheduledTasksByHelpdesk($_SESSION['engineerHelpdesk']);
          break;
          CASE "modify":
            // reroute to add form
            header('Location: /scheduledtask/modify/'.$callid);
            exit;
          CASE "delete":
            // reroute to add form
            header('Location: /scheduledtask/delete/'.$callid);
            exit;
        }
      }

    //set report title
    $templateData->title = "Scheduled task";
    //populate report results for use in view
    $templateData->reportResults = $scheduledtaskModel->getScheduledTasksByHelpdesk($_SESSION['engineerHelpdesk']);
    //get helpdesk details
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    //set page details
    $templateData->details = sizeof($templateData->reportResults)." ".$templateData->title." for ".$helpdeskdetails["helpdesk_name"]." helpdesk.";
    //frequency data
    $templateData->frequency = $scheduledtaskModel->getTaskFrequencyByHelpdesk($_SESSION['engineerHelpdesk']);

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsScheduledTaskView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
