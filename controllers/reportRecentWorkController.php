<?php

class reportRecentWorkController {
  public function __construct()
  {
    //get uri params.
    $baseurl = explode('/', $_SERVER['REQUEST_URI']);
    $engineerid = $baseurl[4];
    //create new models for required data
    $ticketModel = new ticketModel();
    $engineersModel = new engineerModel();

    //create empty object to store data for template
    $templateData = new stdClass();
    $view = new Page();
    if ($engineerid) {
      //set report title
      $templateData->title = "Recent Work Report";
      //populate report results for use in view
      $templateData->reportResults = $ticketModel->getRecentTicketsByEngineerId($engineerid);
      //set page details
      $templateData->details = "Recent tickets (last 7 days) regardless of state closed or assigned to selected engineer.";
      //render template using $pagedata object
      $view->setTemplate('resultsListReportView');
    } else {
      //set report title
      $templateData->title = "Recent Work";
      //set page details
      $templateData->details = "Please select and engineer to view a list of recent tickets they have worked on.";
      //get helpdesks
      $helpdesks = isset($_SESSION['customReportsHelpdesks']) ? $_SESSION['customReportsHelpdesks'] : $_SESSION['engineerHelpdesk']; ;
      //get list of engineers
      $templateData->reportResults = $engineersModel->getListOfEngineersByHelpdeskId($helpdesks);
      //render template using $pagedata object
      $view->setTemplate('resultsListEngineers');
    }
    $view->setDataSrc($templateData);
    $view->render();
  }
}
