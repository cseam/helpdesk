<?php

class reportOutstandingController {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $ticketModel = new ticketModel();
    $engineerModel = new engineerModel();
    $pagedata = new stdClass();
    //set report name
    $reportname = "Outstanding Totals";
    //set report title
    $pagedata->title = $reportname ;
    //set page details
    $pagedata->details = "Outstanding ticket totals count first by status then by engineer.";
    //get helpdesks
    $helpdesks = isset($_SESSION['customReportsHelpdesks']) ? $_SESSION['customReportsHelpdesks'] : $_SESSION['engineerHelpdesk'];
    //populate report results for use in view
    $pagedata->open = $ticketModel->countTicketsByStatusCode(1, $helpdesks);
    $pagedata->escalated = $ticketModel->countTicketsByStatusCode(4, $helpdesks);
    $pagedata->onhold = $ticketModel->countTicketsByStatusCode(3, $helpdesks);
    $pagedata->sentaway = $ticketModel->countTicketsByStatusCode(5, $helpdesks);
    $pagedata->unassigned = sizeof($ticketModel->getUnassignedTicketsByHelpdesk($helpdesks));
    $pagedata->over7days = sizeof($ticketModel->get7DayTicketsByHelpdesk($helpdesks));
    $pagedata->stagnate = sizeof($ticketModel->getStagnateTicketsByHelpdesk($helpdesks));
    $pagedata->reportResults =  $engineerModel->countEngineerTotalsOutstatnding($helpdesks);

    //render template using $pagedata object
    require_once "views/reports/resultsOutstandingTotalsView.php";
  }
}
