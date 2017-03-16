<?php

class reportAnnualGraphsController {
  public function __construct()
  {
    //create new models for required data
    $ticketModel = new ticketModel();
    $helpdeskModel = new helpdeskModel();
    //create empty object to store data for template
    $templateData = new stdClass();
    //set report title
    $templateData->title = "Annual Graphs Totals";
    //set page details
    $templateData->details = "Graph showing the monthly numbers for a defined helpdesk.";
    //define arrays
    $graphstats = $lastyear = $thisyear = $results = array();
    //get helpdesks to plot
    $helpdesks = explode(",", isset($_SESSION['customReportsHelpdesks']) ? $_SESSION['customReportsHelpdesks'] : $_SESSION['engineerHelpdesk']);
    // loop over arrays
    if (is_array($helpdesks)) {
      foreach ($helpdesks as &$value) {
        //get results for year
        $thisyear = $ticketModel->countTotalsThisYearbyHelpdesk(date("Y"), $value);
        $lastyear = $ticketModel->countTotalsThisYearbyHelpdesk(date("Y") - 1, $value);
        //iterate over and merge to get 1 years full data
        for ($i = 1; $i <= 12; $i++) {
          $results[$i] = 0;
          if (is_array($lastyear)) {
            foreach ($lastyear as $lykey => $lyvalue) {
              if ($lyvalue["MonthNum"] == $i) {
                $results[$i] = $lyvalue["Totals"];
              }
            }
          }
          if (is_array($thisyear)) {
            foreach ($thisyear as $tykey => $tyvalue) {
              if ($tyvalue["MonthNum"] == $i) {
                $results[$i] = $tyvalue["Totals"];
              }
            }
          }
        }
        // take this helpdesks results and add to array for page data
        $friendlyname = $helpdeskModel->getFriendlyHelpdeskName($value);
        $templateData->graphstats[$friendlyname["helpdesk_name"]] = $results;
      }
    }
    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsAnnualGraphsView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
