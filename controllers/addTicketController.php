<?php

class addTicketController {
  public function __construct()
  {
    //create new models for required data.
    $ticketModel = new ticketModel();
    $locationModel = new locationModel();
    $helpdeskModel = new helpdeskModel();
    $userProfileModel = new userProfileModel();
    //create empty object to store data for template
    $templateData = new stdClass();
    $templateData->location = $locationModel->getListOfLocations();
    $templateData->helpdesks = $helpdeskModel->getListOfHelpdeskWithoutDeactivated();
    $templateData->userProfile = $userProfileModel->getuserProfileBysAMAccountName($_SESSION['sAMAccountName']);
    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('addticketView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
