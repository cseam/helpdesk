<?php

class actionReportAssignednumbers {
  public function __construct()
  {
    // create new models for required data
      $statsModel = new statsModel();
      $pagedata = new stdClass();
      // Dont need to populate $listdata as fixed partial in manager view

      // Set report name
      $reportname = "Assigned Tickets";
      // set report title
      $pagedata->title = $reportname . " Report";

      // populate report results for use in view
      $pagedata->reportResults = $statsModel->countAssignedTickets();
      // set page details
      $pagedata->details = $reportname. " showing number of tickets assigned, currently open and all time, grouped by enginner.";

      // render template using $pagedata object
      require_once "views/reports/resultsAssignedTicketsView.php";
  }

}
