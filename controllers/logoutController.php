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
      $statsModel = new statsModel();
      //create objects for page
      $stats = array();
      //populate page with data
      $stats = array_merge($stats, $statsModel->countAllTickets());
      $stats = array_merge($stats, $statsModel->countTicketsByOwner($_SESSION['sAMAccountName']));
      //Logout stats
      $logoutstats = array();
      $helpdesks = $helpdeskModel->getListOfHelpdesks();
      foreach ($helpdesks as &$value) {
        $logoutstats[$value['id']]["Name"] = $value['helpdesk_name'];
        $logoutstats[$value['id']]["avgCloseTime"] = $statsModel->advCloseTimeByHelpdeskIdInDays($value['id']);
        $logoutstats[$value['id']]["outstanding"] = $statsModel->countOutstandingTicketsByHelpdesk($value['id']);
        $logoutstats[$value['id']]["totalclosed"] = $statsModel->countTicketsByStatusCode(2 ,$value['id']);
        $logoutstats[$value['id']]["avgfeedback"] = $statsModel->avgHelpdeskFeedbackByHelpdesk($value['id']);
      }
      // render page
    require_once "views/logoutView.php";
  }

}
