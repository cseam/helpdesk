<?php

class actionReportSettings {
  public function __construct()
  {
    $left = new leftpageController();
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    $helpdeskModel = new helpdeskModel();
    //set report name
    $reportname = "Custom Settings";
    //set report title
    $pagedata->title = $reportname;
    //set page details
    $pagedata->details = "Setting a custom date and time range here will force reports to display this range, else they will display the previous month.";
    //get list of helpdesks
    $pagedata->helpdesks = $helpdeskModel->getListOfHelpdeskWithoutDeactivated();


    require_once "views/reports/reportSettings.php";
  }
}
