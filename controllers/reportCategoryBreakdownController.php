<?php

class reportCategoryBreakdownController {
  public function __construct()
  {
    //create new models for required data
    $pagedata = new stdClass();
    $categoryModel = new categoryModel();
    $ticketModel = new ticketModel();
    //set report name
    $reportname = "Category totals";
    //set report title
    $pagedata->title = $reportname . " report";
    //populate report results for use in view
    $pagedata->reportResults = $categoryModel->countCategoryTotals($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = $reportname. " showing total tickets by category for " .sizeof($pagedata->reportResults)." categorys,";
    if (isset($_SESSION['customReportsRangeStart'])) { $pagedata->details .= " from " . $_SESSION['customReportsRangeStart'] . " to " . $_SESSION['customReportsRangeEnd']; } else { $pagedata->details .= " this month."; }
    //render template using $pagedata object
    require_once "views/reports/resultsGraphBarView.php";
  }
}
