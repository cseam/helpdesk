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
      $ticketModel = new ticketModel();
      $statsModel = new statsModel();
      //create objects for page
      $stats = array();
      //populate page with data
      $stats = array_merge($stats, $statsModel->countAllTickets());
      $stats = array_merge($stats, $statsModel->countTicketsByOwner($_SESSION['sAMAccountName']));
      $stats = array_merge($stats, $statsModel->countAllOpenTickets());
      $stats = array_merge($stats, $statsModel->avgHelpdeskFeedback());

      // render page
    require_once "views/logoutView.php";
  }

}
