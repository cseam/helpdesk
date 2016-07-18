<?php

class reportComplianceController {
  public function __construct()
  {
    //create new models for required data
    $ticketModel = new ticketModel();
    $scheduledtaskModel = new scheduledtaskModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Scheduled tasks compliance report";
    //populate report results for use in view
    $scheduledtasks = $scheduledtaskModel->getScheduledTasksByHelpdesk($_SESSION['engineerHelpdesk']);
    foreach ($scheduledtasks as &$values) {
      $compliance = $scheduledtaskModel->getLastComplianceDate($values["title"]);
      $templateData->reportResults[$values["callid"]]["callid"] = $compliance["callid"];
      $templateData->reportResults[$values["callid"]]["task"] = $values["title"];
      $templateData->reportResults[$values["callid"]]["frequency"] = $values["frequencytype"];
      $templateData->reportResults[$values["callid"]]["compliancedate"] = $compliance["closed"];
      $templateData->reportResults[$values["callid"]]["engineer"] = $compliance["engineerName"];
      $templateData->reportResults[$values["callid"]]["daysago"] = $compliance["daysago"];
    }
    //set page details
    $templateData->details = $templateData->title . " showing scheduled task compliance last completed date. ";

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsComplianceView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
