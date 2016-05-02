<?php

class actionReportOutstanding {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $ticketModel = new ticketModel();
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    //set report name
    $reportname = "Outstanding Totals";
    //set report title
    $pagedata->title = $reportname ;
    //set page details
    $pagedata->details = "Outstanding ticket totals count first by status then by engineer.";
    //populate report results for use in view
    $pagedata->open = $statsModel->countTicketsByStatusCode(1, $_SESSION['engineerHelpdesk']);
    $pagedata->escalated = $statsModel->countTicketsByStatusCode(4, $_SESSION['engineerHelpdesk']);
    $pagedata->onhold = $statsModel->countTicketsByStatusCode(3, $_SESSION['engineerHelpdesk']);
    $pagedata->sentaway = $statsModel->countTicketsByStatusCode(5, $_SESSION['engineerHelpdesk']);
    $pagedata->unassigned = sizeof($ticketModel->getUnassignedTicketsByHelpdesk($_SESSION['engineerHelpdesk']));
    $pagedata->over7days = sizeof($ticketModel->get7DayTicketsByHelpdesk($_SESSION['engineerHelpdesk']));
    $pagedata->reportResults = $statsModel->countEngineerTotalsOutstatnding($_SESSION['engineerHelpdesk']);

    //render template using $pagedata object
    require_once "views/reports/resultsOutstandingTotalsView.php";
  }
}
