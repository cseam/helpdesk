<?php

class addChangeControlController {
  public function __construct()
  {
    //create new models for required data
    $changecontrolModel = new changecontrolModel();
    $helpdeskModel = new helpdeskModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //Post Update Objective
      if ($_POST) {
        //create change control
          $engineersid = htmlspecialchars($_SESSION['engineerId']);
          $stamp = date("c");
          $changemade = htmlspecialchars($_POST['details']);
          $tags = null;
          $server = htmlspecialchars($_POST['servername']);
          $helpdesk = $_SESSION['engineerHelpdesk'];
          $changecontrolModel->addChangeControl($engineersid, $stamp, $changemade, $tags, $server, $helpdesk);
        //email engineers
        //get engineers emails
          $emailaddresses = $helpdeskModel->getEngineerEmails($_SESSION['engineerHelpdesk']);
          if (is_array($emailaddresses)) {
            foreach ($emailaddresses as $key => $value) {
              //email managers letting them know a new ticket has been added.
              $to = $value["engineerEmail"];
              $from = "helpdesk@cheltladiescollege.org";
              $title = "Change control added at ".$stamp." for ".$server;
              $emailchangecontrolmessage = "<p>A change control has been added for ".$server." with the following details:</p>";
              $emailchangecontrolmessage .= "<p>".$changemade."</p>";
              $emailchangecontrolmessage .= "<p>To view the details of this change control ticket please <a href=\"".HELPDESK_LOC."\">Visit ".CODENAME."</a></p>";
              $emailchangecontrolmessage .= "<p>This is an automated message please do not reply</p></span>";
              email_user($to, $from, $title, $emailchangecontrolmessage);
            }
          }
      }

    //set report title
    $templateData->title = "Add Change Control";
    $templateData->details = "Please complete the form to add a change control for the team.";

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('addChangeControl');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
