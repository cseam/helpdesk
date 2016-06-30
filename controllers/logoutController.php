<?php

class logoutController {
  public function __construct()
  {
    // process Logouts.
      // update engineers status as out
        //TODO create model for enginners and logout method
      // update engineer punchcard with date and time stamp
        //TODO create update punchcard method
      // destory existing sessions
      session_destroy();
      //create new models for required data
      $helpdeskModel = new helpdeskModel();
      $ticketModel = new ticketModel();
      $feedbackModel = new feedbackModel();
      //create objects for page
      $stats = array();
      //populate page with data
      $stats = array_merge($stats, $ticketModel->countAllTickets());
      $stats = array_merge($stats, $ticketModel->countTicketsByOwner($_SESSION['sAMAccountName']));
      //Logout stats
      $logoutstats = array();
      $helpdesks = $helpdeskModel->getListOfHelpdesks();
      foreach ($helpdesks as &$value) {
        $logoutstats[$value['id']]["Name"] = $value['helpdesk_name'];
        $logoutstats[$value['id']]["avgCloseTime"] = $ticketModel->advCloseTimeByHelpdeskIdInDays($value['id']);
        $logoutstats[$value['id']]["outstanding"] = $ticketModel->countOutstandingTicketsByHelpdesk($value['id']);
        $logoutstats[$value['id']]["totalclosed"] = $ticketModel->countTicketsByStatusCode(2 ,$value['id']);
        $logoutstats[$value['id']]["avgfeedback"] = $feedbackModel->avgHelpdeskFeedbackByHelpdesk($value['id']);
      }
      // render page
    require_once "views/logoutView.php";
  }

}
