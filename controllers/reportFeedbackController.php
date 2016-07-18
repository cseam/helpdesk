<?php

class reportFeedbackController {
  public function __construct()
  {
    //create new models for required data
    $ticketModel = new ticketModel();
    $feedbackModel = new feedbackModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Engineer feedback report";
    //populate report results for use in view
    $templateData->reportResults = $ticketModel->countEngineerFeedbackTotals($_SESSION['engineerHelpdesk']);
    $templateData->poorFeedback = $feedbackModel->getPoorFeedback($_SESSION['engineerHelpdesk']);
    //set page details
    $templateData->details = $templateData->title . " showing average feedback for " .sizeof($templateData->reportResults)." engineers, and poor feedback, ";
    if (isset($_SESSION['customReportsRangeStart'])) { $templateData->details .= " from " . $_SESSION['customReportsRangeStart'] . " to " . $_SESSION['customReportsRangeEnd']; } else { $templateData->details .= " this month."; }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsFeedbackReportView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
