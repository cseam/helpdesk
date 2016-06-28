<?php

class reportFeedbackController {
  public function __construct()
  {
    //dont need to populate $listdata as fixed partial in manager view
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    $ticketModel = new ticketModel();
    $feedbackModel = new feedbackModel();
    //set report name
    $reportname = "Engineer feedback";
    //set report title
    $pagedata->title = $reportname . " report";
    //populate report results for use in view
    $pagedata->reportResults = $ticketModel->countEngineerFeedbackTotals($_SESSION['engineerHelpdesk']);
    $pagedata->poorFeedback = $feedbackModel->getPoorFeedback($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = $reportname. " showing average feedback for " .sizeof($pagedata->reportResults)." engineers, and poor feedback, ";
    if (isset($_SESSION['customReportsRangeStart'])) { $pagedata->details .= " from " . $_SESSION['customReportsRangeStart'] . " to " . $_SESSION['customReportsRangeEnd']; } else { $pagedata->details .= " this month."; }

    //render template using $pagedata object
    require_once "views/reports/resultsFeedbackReportView.php";
  }
}
