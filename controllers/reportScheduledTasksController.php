<?php

class reportScheduledTasksController {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $helpdeskModel = new helpdeskModel();
    $scheduledtaskModel = new scheduledtaskModel();
    $pagedata = new stdClass();

    //Post Update Objective
      if ($_POST) {
        $callid = isset($_POST['callid']) ? $_POST['callid'] : null;
        $switch = (isset($_POST["button_modify_value"]) ? $_POST["button_modify_value"] : $_POST["button_value"]);
        SWITCH ($switch) {
          CASE "add":
            // reroute to add form
            header('Location: /scheduledtask/add');
            exit;
          break;
          CASE "modify":
            // reroute to add form
            header('Location: /scheduledtask/modify/'.$callid);
            exit;
          break;
          CASE "delete":
            // reroute to add form
            header('Location: /scheduledtask/delete/'.$callid);
            exit;
          break;
        }
      }

    //set report name
    $reportname = "Scheduled Task";
    //set report title
    $pagedata->title = $reportname . "";
    //populate report results for use in view
    $pagedata->reportResults = $scheduledtaskModel->getScheduledTasksByHelpdesk($_SESSION['engineerHelpdesk']);
    //get helpdesk details
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = sizeof($pagedata->reportResults)." ".$reportname." for ".$helpdeskdetails["helpdesk_name"]." helpdesk.";
    //render template using $pagedata object
    require_once "views/reports/resultsScheduledTaskView.php";
  }
}
