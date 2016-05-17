<?php

class actionReportAnnualgraphs {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $ticketModel = new ticketModel();
    $statsModel = new statsModel();
    $pagedata = new stdClass();
    //set report name
    $reportname = "Annual Graphs Totals";
    //set report title
    $pagedata->title = $reportname ;
    //set page details
    $pagedata->details = "Graph showing the monthly numbers for a defined helpdesk.";

    $helpdesks = explode(",", $_SESSION['engineerHelpdesk']);
    $graphstats = $lastyear = $thisyear = $results = array();
    foreach ($helpdesks as &$value) {
    //  $graphstats[$value] = $statsModel->countTotalsThisYearbyHelpdesk(date("Y"), $value);

    $thisyear = $statsModel->countTotalsThisYearbyHelpdesk(date("Y"), $value);
    $lastyear = $statsModel->countTotalsThisYearbyHelpdesk(date("Y")-1, $value);

      for($i=1; $i <= 12; $i++) {
        $results[$i]["result"] = 0;
        foreach ($lastyear as &$value) {
          if ($value["MonthNum"] == $i) {
            $results[$i]["result"] = $value["Totals"];
          }
        }
        foreach ($thisyear as &$value) {
            if ($value["MonthNum"] == $i) {
              $results[$i]["result"] = $value["Totals"];
          }
        }
        $graphstats[$value] = $results[$i];
      }
    }

    $pagedata->graphstats = $graphstats;
    //render template using $pagedata object
    require_once "views/reports/resultsAnnualGraphsView.php";
  }
}
