<?php

class actionReportFeedback {
  public function __construct()
  {
    // Dont need to populate $listdata as fixed partial in manager view
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    // Dont need to populate $listdata as fixed partial in manager view

  // Set report name
  $reportname = "Engineer feedback";
  // set report title
  $pagedata->title = $reportname . " report";

  // populate report results for use in view
  $pagedata->reportResults = $statsModel->countEngineerFeedbackTotals();
  $pagedata->poorFeedback = $statsModel->getPoorFeedback();
  
  // set page details
  $pagedata->details = $reportname. " showing average feedback for " .sizeof($pagedata->reportResults)." enginners across all helpdesks.";

  // render template using $pagedata object
  require_once "views/reports/resultsFeedbackReportView.php";  }

}
