<?php

class reportFeedbackListController {
  public function __construct()
  {
    //get ticket id from uri params.
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $id = $baseurl[3];
    //dont need to populate $listdata as fixed partial in manager view
    $pagedata = new stdClass();
    $feedbackModel = new feedbackModel();
    $ticketModel = new ticketModel();
    //set report name
    $reportname = "Engineer feedback";
    //set report title
    $pagedata->title = $reportname . " report";
    //populate report results for use in view
    $pagedata->reportResults = $feedbackModel->getFeedbackDetailsByEngineerId($id);
    //set page details
    $pagedata->details = $reportname. " showing feedback left by users.";

    //render template using $pagedata object
    require_once "views/reports/resultsFeedbackListView.php";
  }
}
