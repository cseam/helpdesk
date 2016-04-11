<?php

class actionAddScheduledtask {
  public function __construct()
  {
    //create new models for required data
    $changecontrolModel = new changecontrolModel();
    $helpdeskModel = new helpdeskModel();
    $pagedata = new stdClass();

    //Post Update Objective
      if ($_POST) {
        //create change control
//          $engineersid = htmlspecialchars($_SESSION['engineerId']);
//          $stamp = date("c");
//          $changemade = htmlspecialchars($_POST['details']);
//          $tags = null;
//          $server = htmlspecialchars($_POST['servername']);
//          $helpdesk = $_SESSION['engineerHelpdesk'];
//          $changecontrolModel->addChangeControl($engineersid, $stamp, $changemade, $tags, $server, $helpdesk);
      }

    //set report name
    $reportname = "Add Scheduled Task";
    //set report title
    $pagedata->title = $reportname;
    $pagedata->details = "Please complete the form to add a scheduled task for the team.";

    //render template using $pagedata object
    require_once "views/addScheduledtask.php";

  }
}
