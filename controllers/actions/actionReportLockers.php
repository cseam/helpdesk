<?php

class actionReportLockers {
  public function __construct()
  {
    //create new models for required data
    $statsModel = new statsModel();
    $helpdeskModel = new helpdeskModel();
    $lockersModel = new lockersModel();
    $pagedata = new stdClass();
    //dont need to populate $listdata as fixed partial in manager view
    //set report name
    $reportname = "lockers";
    //set report title
    $pagedata->title = $reportname . "";
    //get department workrate for graph
    $stats = $statsModel->countDepartmentWorkrateByDay($_SESSION['engineerHelpdesk']);
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
