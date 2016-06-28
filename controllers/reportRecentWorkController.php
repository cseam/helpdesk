<?php

class reportRecentWorkController {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //get uri params.
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $engineerid = $baseurl[3];
    //create new models for required data
    $ticketModel = new ticketModel();
    $statsModel = new statsModel();
    $engineersModel = new engineerModel();
    $pagedata = new stdClass();
    if ($engineerid) {
      //set report name
      $reportname = "Recent Work Report";
      //set report title
      $pagedata->title = $reportname;
      //populate report results for use in view
      $pagedata->reportResults = $ticketModel->getRecentTicketsByEngineerId($engineerid);
      //set page details
      $pagedata->details = "Recent tickets (last 7 days) regardless of state closed or assigned to selected engineer.";
      //render template using $pagedata object
      require_once "views/reports/resultsListReportView.php";
    } else {
      //set report name
      $reportname = "Recent Work";
      //set report title
      $pagedata->title = $reportname;
      //set page details
      $pagedata->details = "Please select and engineer to view a list of recent tickets they have worked on.";
      //get helpdesks
      $helpdesks = isset($_SESSION['customReportsHelpdesks']) ? $_SESSION['customReportsHelpdesks'] : $_SESSION['engineerHelpdesk'];
      //get list of engineers
      $pagedata->reportResults = $engineersModel->getListOfEngineersByHelpdeskId($helpdesks);
      //render template using $pagedata object
      require_once "views/reports/resultsListEngineers.php";
    }


  }
}
