<?php

class actionReportSla {
  public function __construct()
  {
    $servicelevelagreementModel = new servicelevelagreementModel();
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    $SLAtotals = new stdClass();
    //set report name
    $reportname = "Service Level Agreement";
    //set report title
    $pagedata->title = $reportname . " report";
    //populate report results for use in view
    $pagedata->reportResults = $servicelevelagreementModel->GetFailedSLALastMonth($_SESSION['engineerHelpdesk']);
    //calculate SLA performance
    for ($i=1; $i<=10; $i++) {
      // hard coded 10 SLAs {clown fiesta should not be hard coded FIX THIS}
      $SLAtotals->$i = $servicelevelagreementModel->GetSLAPerformance($_SESSION['engineerHelpdesk'], $i);
    }
    //set page details
    $pagedata->details = $reportname. " showing tickets that failed SLA last month.";
    //render template using $pagedata object
    require_once "views/reports/resultsSLAReportView.php";
  }
}
