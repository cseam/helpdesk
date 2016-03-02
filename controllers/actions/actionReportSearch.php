<?php

class actionReportSearch {
  public function __construct()
  {
    // create new models for required data
      $statsModel = new statsModel();
      $ticketModel = new ticketModel();
      $helpdeskModel = new helpdeskModel();
      $pagedata = new stdClass();
      // Dont need to populate $listdata as fixed partial in manager view

    // Set report name
    $reportname = "Search";
    // set report title
    $pagedata->title = $reportname . " Tickets";

    // Populate $stats for Graph
    $stats = $statsModel->countDepartmentWorkrateByDay($_SESSION['engineerHelpdesk']);
    // set page details
    $pagedata->details = sizeof($pagedata->reportResults)." ".$reportname." tickets for ".$helpdeskdetails["helpdesk_name"]." helpdesk.";

    // render template using $pagedata object
    require_once "views/searchView.php";
  }

}
