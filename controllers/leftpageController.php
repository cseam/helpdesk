<?php

class leftpageController {

  public $sideData;

  public function __construct()
  {
    $ticketModel = new ticketModel();
    $engineerModel = new engineerModel();
    $objectivesModel = new objectivesModel();
    //check what level engineer are they in the system
    SWITCH ($_SESSION['engineerLevel']) {
      //populate objects with data for correct left side & tell view which partial to load
        CASE "0":
        // standard user
          $this->sideData["partial"] = "user.php";
          $this->sideData["mytickets"] = $ticketModel->getMyTickets($_SESSION['sAMAccountName'], 15);
        break;
        CASE "1":
        // engineer
          $this->sideData["mytickets"] = $ticketModel->getMyTickets($_SESSION['sAMAccountName'], 15);
          $this->sideData["listdata"] = $ticketModel->getMyOpenAssignedTickets($_SESSION['engineerId']);
          $this->sideData["deptdata"] = $ticketModel->getOpenTicketsByHelpdesk($_SESSION['engineerHelpdesk']);
          $this->sideData["objdata"] = $objectivesModel->getObjectivesByEngineerId($_SESSION['engineerId']);
            $graphstats = array();
            $graphstats = array_merge($graphstats, $ticketModel->countAllTicketsByEngineerIdLastWeek($_SESSION['engineerId']));
            $graphstats = array_merge($graphstats, $ticketModel->countClosedByEngineerIdLastWeek($_SESSION['engineerId']));
            $graphstats = array_merge($graphstats, $ticketModel->countEngineerTotalsLastWeek($_SESSION['engineerId']));
          $this->sideData["graphdata"] = $graphstats;
          $this->sideData["partial"] = "engineer.php";
        break;
        CASE "2":
        // manager
          $this->sideData["mytickets"] = $ticketModel->getMyTickets($_SESSION['sAMAccountName'], 15);
          $this->sideData["assistdata"] = $engineerModel->countAssistWorkrateByDay($_SESSION['engineerHelpdesk']);
          $this->sideData["graphdata"] = $engineerModel->countDepartmentWorkrateByDay($_SESSION['engineerHelpdesk']);
          $this->sideData["partial"] = "manager.php";
        break;
    }
      // superusers have different left menus as they see much more
    if ($_SESSION['superuser']) {
      //change side partial depending on uri.
      $baseurl = explode('/', $_SERVER['REQUEST_URI']);
      SWITCH ($baseurl[1]) {
        CASE "engineer":
          $this->sideData["mytickets"] = $ticketModel->getMyTickets($_SESSION['sAMAccountName'], 15);
          $this->sideData["listdata"] = $ticketModel->getMyOpenAssignedTickets($_SESSION['engineerId']);
          $this->sideData["deptdata"] = $ticketModel->getOpenTicketsByHelpdesk($_SESSION['engineerHelpdesk']);
          $this->sideData["objdata"] = $objectivesModel->getObjectivesByEngineerId($_SESSION['engineerId']);
            $graphstats = array();
            $graphstats = array_merge($graphstats, $ticketModel->countAllTicketsByEngineerIdLastWeek($_SESSION['engineerId']));
            $graphstats = array_merge($graphstats, $ticketModel->countClosedByEngineerIdLastWeek($_SESSION['engineerId']));
            $graphstats = array_merge($graphstats, $ticketModel->countEngineerTotalsLastWeek($_SESSION['engineerId']));
          $this->sideData["graphdata"] = $graphstats;
          $this->sideData["partial"] = "engineer.php";
        break;
        CASE "manager":
          $this->sideData["partial"] = "manager.php";
          $this->sideData["assistdata"] = $engineerModel->countAssistWorkrateByDay($_SESSION['engineerHelpdesk']);
          $this->sideData["graphdata"] = $engineerModel->countDepartmentWorkrateByDay($_SESSION['engineerHelpdesk']);
        break;
        CASE "report":
          $this->sideData["partial"] = "reports.php";
        break;

      };

    }


  }

}
