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

    //define arrays
    $graphstats = $lastyear = $thisyear = $results = array();
    //get helpdesks to plot
    $helpdesks = explode(",", $_SESSION['engineerHelpdesk']);
    // loop over arrays
    foreach ($helpdesks as &$value) {

    //get results for year
    $thisyear = $statsModel->countTotalsThisYearbyHelpdesk(date("Y"), $value);
    $lastyear = $statsModel->countTotalsThisYearbyHelpdesk(date("Y")-1, $value);

    //iterate over and merge to get 1 years full data
      for($i=1; $i <= 12; $i++) {
        $results[$i] = 0;
        foreach ($lastyear as $key => $value) {
          if ($value["MonthNum"] == $i) { $results[$i] = $value["Totals"]; }
        }
        foreach ($thisyear as $key => $value) {
          if ($value["MonthNum"] == $i) { $results[$i] = $value["Totals"]; }
        }
      }

    // take this helpdesks results and add to array for page data
    $pagedata->graphstats[$key] = $results;

    }

    //render template using $pagedata object
    require_once "views/reports/resultsAnnualGraphsView.php";
  }
}
