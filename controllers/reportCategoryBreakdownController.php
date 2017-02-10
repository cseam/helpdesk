<?php

class reportCategoryBreakdownController {
  public function __construct()
  {
    //create new models for required data
    $categoryModel = new categoryModel();
    $ticketModel = new ticketModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Category totals report";
    //populate report results for use in view
    $templateData->reportResults = $categoryModel->countCategoryTotals($_SESSION['engineerHelpdesk']);
    //set page details
    $templateData->details = $templateData->title." showing total tickets by category for ".sizeof($templateData->reportResults)." categorys,";
    if (isset($_SESSION['customReportsRangeStart'])) { $templateData->details .= " from ".$_SESSION['customReportsRangeStart']." to ".$_SESSION['customReportsRangeEnd']; } else { $templateData->details .= " this month."; }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsGraphBarView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
