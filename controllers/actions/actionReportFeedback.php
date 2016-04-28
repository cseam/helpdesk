<?php

class actionReportFeedback {
  public function __construct()
  {
    //dont need to populate $listdata as fixed partial in manager view
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    //set report name
    $reportname = "Engineer feedback";
    //set report title
    $pagedata->title = $reportname . " report";
    //populate report results for use in view
    $pagedata->reportResults = $statsModel->countEngineerFeedbackTotals($_SESSION['engineerHelpdesk']);
    $pagedata->poorFeedback = $statsModel->getPoorFeedback($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = $reportname. " showing average feedback for " .sizeof($pagedata->reportResults)." engineers, and poor feedback in last 30 days.";
    //render template using $pagedata object
    require_once "views/reports/resultsFeedbackReportView.php";
  }
}
