<?php

class formDescriptionTicketController {
  public function __construct()
  {
    //get ticket id from uri params
    $baseurl = explode('/',$_SERVER['REQUEST_URI']);
    $helpdeskid = $baseurl[3];
    //create new models for required data
    $helpdeskModel = new helpdeskModel();
    //get helpdesk description
    $description = $helpdeskModel->getHelpdeskDescription($helpdeskid);
    //since not being viewed used to update dropdown not passed to view just rendered
    echo "<p>" . $description["description"] . "</p>";
  }

}
