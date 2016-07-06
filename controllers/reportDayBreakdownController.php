<?php

class reportDayBreakdownController {
  public function __construct()
  {
    //create new models for required data
    $ticketModel = new ticketModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Day activity report";
    //populate report results for use in view
    $templateData->reportResults = $ticketModel->countDayBreakdownTotals($_SESSION['engineerHelpdesk']);
    //set page details
    $templateData->details = $templateData->title . " showing helpdesk activity by time of day, ";
    if (isset($_SESSION['customReportsRangeStart'])) { $templateData->details .= " from " . $_SESSION['customReportsRangeStart'] . " to " . $_SESSION['customReportsRangeEnd']; } else { $templateData->details .= " this month."; }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsDayBreakdownReportView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
