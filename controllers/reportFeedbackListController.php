<?php

class reportFeedbackListController {
  public function __construct()
  {
    //get ticket id from uri params.
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $id = $baseurl[3];
    //create new models for required data
    $feedbackModel = new feedbackModel();
    $ticketModel = new ticketModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Engineer feedback report";
    //populate report results for use in view
    $templateData->reportResults = $feedbackModel->getFeedbackDetailsByEngineerId($id);
    //set page details
    $templateData->details = $templateData->title . " showing feedback left by users.";

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('resultsFeedbackListView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
