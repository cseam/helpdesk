<?php

class actionReportPunchcard {
  public function __construct()
  {
    // Dont need to populate $listdata as fixed partial in manager view
    // Dont need to populate $stats as fixed partial in manager view

    $pagedata = new stdClass();
    $pagedata->title = "Punchcard Tickets";

    // populate report
    $ticketModel = new ticketModel();
    $pagedata->reportResults = $ticketModel->getUnassignedTicketsByHelpdesk(4);

    // render page
    require_once "views/managerView.php";
  }

}
