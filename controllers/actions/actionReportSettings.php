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
    //Post Update Custom Settings
      if ($_POST) {
        // check valid start date
        $_SESSION['customReportsRangeStart'] = checkdate( substr($_POST["date-range"] , 3, 2) , substr($_POST["date-range"] , 0, 2) , substr($_POST["date-range"] , 6, 4) ) ? substr($_POST["date-range"] , 0, 10) : null;
        $_SESSION['customReportsRangeEnd'] = checkdate( substr($_POST["date-range"] , 16, 2) , substr($_POST["date-range"] , 13, 2) , substr($_POST["date-range"] , 19, 4) ) ? substr($_POST["date-range"] , 13, 10) : null;
        $_SESSION['customReportsHelpdesks'] = htmlspecialchars($_POST["helpdesks"]);
        $pagedata->success = "Settings updated, reports will now use your custom settings.";
      }

    require_once "views/reports/reportSettings.php";
  }
}
