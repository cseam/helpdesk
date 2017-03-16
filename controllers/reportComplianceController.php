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
    if (is_array($scheduledtasks)) {
      foreach ($scheduledtasks as &$values) {
        $compliance = $scheduledtaskModel->getLastComplianceDate($values["title"]);
        $templateData->reportResults[$values["callid"]]["callid"] = $compliance["callid"];
        $templateData->reportResults[$values["callid"]]["task"] = $values["title"];
        $templateData->reportResults[$values["callid"]]["frequency"] = $values["frequencytype"];
        $templateData->reportResults[$values["callid"]]["compliancedate"] = $compliance["closed"];
        $templateData->reportResults[$values["callid"]]["engineer"] = $compliance["engineerName"];
        $templateData->reportResults[$values["callid"]]["daysago"] = $compliance["daysago"];
        switch ($values["frequencytype"]) {
          case 'daily':
            if ($compliance["daysago"] > 2) {
              $templateData->reportResults[$values["callid"]]["overdue"] = 1;
            }
            break;
          case 'weekly':
            if ($compliance["daysago"] > 7) {
              $templateData->reportResults[$values["callid"]]["overdue"] = 1;
            }
            break;
          case 'monthly':
            if ($compliance["daysago"] > 31) {
              $templateData->reportResults[$values["callid"]]["overdue"] = 1;
            }
            break;
          case 'yearly':
            if ($compliance["daysago"] > 365) {
              $templateData->reportResults[$values["callid"]]["overdue"] = 1;
            }
            break;
          case 'bi-annual':
            if ($compliance["daysago"] > 730) {
              $templateData->reportResults[$values["callid"]]["overdue"] = 1;
            }
            break;
          default:
            $templateData->reportResults[$values["callid"]]["overdue"] = null;
            break;
        }
      }
    }
    //set page details
    $templateData->details = $templateData->title." showing scheduled task compliance last completed date. ";
    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsComplianceView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
