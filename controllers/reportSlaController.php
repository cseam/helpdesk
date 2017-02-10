<?php

class reportSlaController {
  public function __construct()
  {
    //create new models required
    $servicelevelagreementModel = new servicelevelagreementModel();
    $ticketModel = new ticketModel();
    //create empty object to store data for template
    $templateData = new stdClass();


    $SLAtotals = new stdClass();

    //set report title
    $templateData->title = "Service Level Agreement report";
    //populate report results for use in view
    $templateData->reportResults = $servicelevelagreementModel->GetFailedSLALastMonth($_SESSION['engineerHelpdesk']);
    //calculate SLA performance
    for ($i = 1; $i <= 10; $i++) {
      // hard coded 10 SLAs {clown fiesta should not be hard coded FIX THIS}
      $SLAtotals->$i = $servicelevelagreementModel->GetSLAPerformance($_SESSION['engineerHelpdesk'], $i);
    }
    //set page details
    $templateData->details = $templateData->title." showing tickets that failed SLA, ";
    if (isset($_SESSION['customReportsRangeStart'])) { $templateData->details .= " from ".$_SESSION['customReportsRangeStart']." to ".$_SESSION['customReportsRangeEnd']; } else { $templateData->details .= " this month."; }

    $templateData->SLAtotals = $SLAtotals;

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsSLAReportView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
