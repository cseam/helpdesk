<?php

class leftpageController {

  public $sideData;

  public function __construct()
  {
    $ticketModel = new ticketModel();
    $objectivesModel = new objectivesModel();
    $statsModel = new statsModel();
    //what level engineer are they in the system
    SWITCH ($_SESSION['engineerLevel']) {
      //populate objects with data for correct left side & tell view which partial to load
        CASE "0":
        // standard user
          $this->sideData["partial"] = "user.php";
          $this->sideData["mytickets"] = $ticketModel->getMyTickets($_SESSION['sAMAccountName'], 30);
        break;
        CASE "1":
        // engineer
          $this->sideData["mytickets"] = $ticketModel->getMyTickets($_SESSION['sAMAccountName'], 30);
          $this->sideData["listdata"] = $ticketModel->getMyOpenAssignedTickets($_SESSION['engineerId']);
          $this->sideData["deptdata"] = $ticketModel->getOpenTicketsByHelpdesk($_SESSION['engineerHelpdesk']);
          $this->sideData["objdata"] = $objectivesModel->getObjectivesByEngineerId($_SESSION['engineerId']);
            $graphstats = array();
            $graphstats = array_merge($graphstats, $statsModel->countAllTicketsByEngineerIdLastWeek($_SESSION['engineerId']));
            $graphstats = array_merge($graphstats, $statsModel->countClosedByEngineerIdLastWeek($_SESSION['engineerId']));
            $graphstats = array_merge($graphstats, $statsModel->countEngineerTotalsLastWeek($_SESSION['engineerId']));
          $this->sideData["graphdata"] = $graphstats;
          $this->sideData["partial"] = "engineer.php";
        break;
        CASE "2":
        // manager
          $this->sideData["mytickets"] = $ticketModel->getMyTickets($_SESSION['sAMAccountName'], 30);
          $this->sideData["graphdata"] = $statsModel->countDepartmentWorkrateByDay($_SESSION['engineerHelpdesk']);
          $this->sideData["partial"] = "manager.php";
        break;
    }
      // superusers have different left menus as they see much more
    if ($_SESSION['superuser']) {
      //change side partial depending on uri.
      $baseurl = explode('/',$_SERVER['REQUEST_URI']);
      SWITCH ($baseurl[1]) {
        CASE "engineer":
          $this->sideData["mytickets"] = $ticketModel->getMyTickets($_SESSION['sAMAccountName'], 30);
          $this->sideData["listdata"] = $ticketModel->getMyOpenAssignedTickets($_SESSION['engineerId']);
          $this->sideData["deptdata"] = $ticketModel->getOpenTicketsByHelpdesk($_SESSION['engineerHelpdesk']);
          $this->sideData["objdata"] = $objectivesModel->getObjectivesByEngineerId($_SESSION['engineerId']);
            $graphstats = array();
            $graphstats = array_merge($graphstats, $statsModel->countAllTicketsByEngineerIdLastWeek($_SESSION['engineerId']));
            $graphstats = array_merge($graphstats, $statsModel->countClosedByEngineerIdLastWeek($_SESSION['engineerId']));
            $graphstats = array_merge($graphstats, $statsModel->countEngineerTotalsLastWeek($_SESSION['engineerId']));
          $this->sideData["graphdata"] = $graphstats;
          $this->sideData["partial"] = "engineer.php";
        break;
        CASE "manager":
          $this->sideData["partial"] = "manager.php";
          $this->sideData["graphdata"] = $statsModel->countDepartmentWorkrateByDay($_SESSION['engineerHelpdesk']);
        break;
      };

    }


  }

}
