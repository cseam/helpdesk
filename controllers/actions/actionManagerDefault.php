<?php

class actionManagerDefault {
  public function __construct()
  {
    //dont need to populate $listdata as fixed partial in manager view
    //populate Graph
    //new Stats model
    $statsModel = new statsModel();
    $stats = $statsModel->countDepartmentWorkrateByDay($_SESSION['engineerHelpdesk']);
    //populate page content
    $pagedata = new stdClass();
    $pagedata->title = "manager method test";
    $pagedata->summary = "
      //TODO
        escalated Tickets
        unassigned Tickets
        stagnate Tickets
        poor feedback
      ";
    //render page
    require_once "views/managerView.php";
  }
}
