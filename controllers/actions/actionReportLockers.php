<?php

class actionReportLockers {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $helpdeskModel = new helpdeskModel();
    $lockersModel = new lockersModel();
    $pagedata = new stdClass();
    //set report name
    $reportname = "lockers";
    //set report title
    $pagedata->title = $reportname . "";
    //get helpdesk details
    $helpdeskdetails = $helpdeskModel->getFriendlyHelpdeskName($_SESSION['engineerHelpdesk']);
    //set page details
    $pagedata->details = sizeof($pagedata->reportResults)." items in ".$reportname." for ".$helpdeskdetails["helpdesk_name"]." helpdesk.";
    //if post update database
    if ($_POST) {
      //remove item from lockers
      $lockersModel->removeItemFromLockerById($_POST["callid"], $_SESSION['sAMAccountName']);
      //update page message
      $pagedata->details = "<p>Item Returned - Ticket #".$_POST["callid"]." Updated</p><p>Ticket has been updated to show when the user collected the item, and who issued the item.</p>";
    }
    //populate report results for use in view
    $pagedata->reportResults = $lockersModel->getLockersByHelpdesk($_SESSION['engineerHelpdesk']);
    //render template using $pagedata object
    require_once "views/reports/resultsLockersView.php";
  }
}
