<?php

class actionReportDefault {
  public function __construct()
  {
    //create new models for required data
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    //dont need to populate $listdata as fixed partial in manager view
    //set report name
    $reportname = "Day Breakdown";
    //set report title
    $pagedata->title = $reportname . " Report";
    //populate report results for use in view
    $pagedata->reportResults = $statsModel->countDayBreakdownTotalsLastMonth();
    //set page details
    $pagedata->details = $reportname. " showing helpdesk activity by time of day for ". date("F Y", strtotime("first day of previous month")) ." across all helpdesks.";
    //render template using $pagedata object
    require_once "views/reports/resultsDayBreakdownReportView.php";
  }
}
