<?php

class feedbackTicketController {
  public function __construct()
  {
    //get ticket id from uri params
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $ticketid = $baseurl[3];
    //create new models for required data
    $ticketModel = new ticketModel();
    $feedbackModel = new feedbackModel();
    //populate users ticket list
    $listdata = $ticketModel->getMyTickets($_SESSION['sAMAccountName'], 20);
    //populate tickets data
    $ticketDetails = $ticketModel->getTicketDetails($ticketid);
    $additionalDetails = $ticketModel->getAdditionalDetails($ticketid);

    // on post process form
    if ($_POST) {
      $formid = htmlspecialchars($_POST['id']);
      $formdetails = htmlspecialchars($_POST['updatedetails']);
      $formsatisfaction = htmlspecialchars($_POST['satisfaction']);
      $feedbackModel->addFeedbackToTicketById($formid, $formsatisfaction, $formdetails);
      $message = "<h2>Thankyou</h2><p>Your feedback has been submitted thankyou for taking the time to let us know how we performed.</p>";
    }
    // render page
    require_once "views/feedbackView.php";

  }
}
