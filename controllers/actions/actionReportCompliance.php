<?php

class actionReportCompliance {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    $scheduledtaskModel = new scheduledtaskModel();
    //set report name
    $reportname = "Scheduled Tasks Compliance";
    //set report title
    $pagedata->title = $reportname . " Report";
    //populate report results for use in view
    $scheduledtasks = $scheduledtaskModel->getScheduledTasksByHelpdesk($_SESSION['engineerHelpdesk']);
    foreach ($scheduledtasks as &$values) {
      $compliance = $scheduledtaskModel->getLastComplianceDate($values["title"]);
      $pagedata->reportResults[$values["callid"]]["callid"] = $compliance["callid"];
      $pagedata->reportResults[$values["callid"]]["task"] = $values["title"];
      $pagedata->reportResults[$values["callid"]]["frequency"] = $values["frequencytype"];
      $pagedata->reportResults[$values["callid"]]["compliancedate"] = $compliance["closed"];
      $pagedata->reportResults[$values["callid"]]["engineer"] = $compliance["engineerName"];
      $pagedata->reportResults[$values["callid"]]["daysago"] = $compliance["daysago"];
    }
    //set page details
    $pagedata->details = $reportname. " showing scheduled task compliance last completed date. ";
    require_once "views/reports/resultsComplianceView.php";
  }
}
