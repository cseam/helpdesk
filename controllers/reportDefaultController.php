<?php

class reportDefaultController {
  public function __construct()
  {
    //create new models for required data
    $ticketModel = new ticketModel();
    $feedbackModel = new feedbackModel();
    $categoryModel = new categoryModel();
    $servicelevelagreementModel = new servicelevelagreementModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Reports Summary";
    //set page details
    $templateData->details = $templateData->title. " showing helpdesk activity, ";
    if (isset($_SESSION['customReportsRangeStart'])) { $templateData->details .= " from " . $_SESSION['customReportsRangeStart'] . " to " . $_SESSION['customReportsRangeEnd']; } else { $templateData->details .= " this month."; }
    //populate report results for use in view
    $templateData->opentickets = $ticketModel->countOutstandingTicketsByHelpdesk($_SESSION['engineerHelpdesk']);
    $templateData->closedtickets = $ticketModel->countClosed($_SESSION['engineerHelpdesk']);
    $templateData->activity = $ticketModel->countActivity($_SESSION['engineerHelpdesk']);
    $SLAtotals = new stdClass();
    for ($i=1; $i<=10; $i++) {
      // hard coded 10 SLAs {clown fiesta should not be hard coded FIX THIS}
      $SLAtotals->$i = $servicelevelagreementModel->GetSLAPerformance($_SESSION['engineerHelpdesk'], $i);
    }
    $total = $first = $close = 0;
    foreach ($SLAtotals as $key => $value) {
      $total += $value["Total"];
      $first += $value["FirstResponseSuccess"];
      $close += $value["ResponseTimeSuccess"];
    }
    $templateData->firstresponse = number_format(($total !== 0 ? ($first / $total) : 0) * 100 ,2);
    $templateData->closetime = number_format(($total !== 0 ? ($close / $total) : 0) * 100 ,2);
    $templateData->avgfeedback = $feedbackModel->avgFeedback($_SESSION['engineerHelpdesk']);
    $templateData->topcategory = $categoryModel->topCategory($_SESSION['engineerHelpdesk']);
    $templateData->avgurgency = $ticketModel->avgUrgency($_SESSION['engineerHelpdesk']);
    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsOverview');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
