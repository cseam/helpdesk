<?php

class feedbackTicketController {
  public function __construct()
  {
    //get ticket id from uri params
    $baseurl = explode('/', $_SERVER['REQUEST_URI']);
    $ticketid = $baseurl[3];
    //create new models for required data
    $ticketModel = new ticketModel();
    $feedbackModel = new feedbackModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //pass details for view
    $templateData->ticketid = $ticketid;
    //populate users ticket list
    $templateData->listdata = $ticketModel->getMyTickets($_SESSION['sAMAccountName'], 20);
    //populate tickets data
    $templateData->ticketDetails = $ticketModel->getTicketDetails($ticketid);
    $templateData->ticketUpdates = $ticketModel->getTicketUpdatesByCallId($ticketid);
    $templateData->additionalDetails = $ticketModel->getAdditionalDetails($ticketid);
    //populate est ticket time total
    $esttimetotal = 0;
    foreach ($templateData->ticketUpdates as &$update) { $esttimetotal += $update["esttime"]; }
    $templateData->ticketDetails["esttime"] = $esttimetotal.' min';
    // on post process form
    if ($_POST) {
      $formid = htmlspecialchars($_POST['id']);
      $formdetails = htmlspecialchars($_POST['updatedetails']);
      $formsatisfaction = htmlspecialchars($_POST['satisfaction']);
      $feedbackModel->addFeedbackToTicketById($formid, $formsatisfaction, $formdetails);
      $templateData->message = "<h2>Thankyou</h2><p>Your feedback has been submitted thankyou for taking the time to let us know how we performed.</p>";
    }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('feedbackView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
