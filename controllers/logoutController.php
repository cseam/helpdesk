<?php

class logoutController {
  public function __construct()
  {
      // create models required
      $engineerModel = new engineerModel();
      $helpdeskModel = new helpdeskModel();
      $ticketModel = new ticketModel();
      $feedbackModel = new feedbackModel();
      //create empty object to store data for template
      $templateData = new stdClass();
      // log engineer logout
      $engineerModel->logEngineerAccess($_SESSION['engineerId'], 0);
      // update engineers status as out
      $engineerModel->updateEngineerStatus($_SESSION['engineerId'], 0);


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

      //pass data to templateData
      $templateData->stats = $stats;
      $templateData->logoutstats = $logoutstats;

      //pass complete data and template to view engine and render
      $view = new Page();
      $view->setTemplate('logoutView');
      $view->setDataSrc($templateData);
      $view->render();

      // destory existing sessions
      session_destroy();
  }

}
