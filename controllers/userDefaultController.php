<?php

class userDefaultController {
  public function __construct()
  {
    //create new models for required data
    $ticketModel = new ticketModel();
    $userProfileModel = new userProfileModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report name
    $templateData->title = "Recent Ticket Activity";
    $templateData->reportResults = $ticketModel->getRecentActivityByOwner($_SESSION['sAMAccountName']);
    $templateData->closedTickets = $ticketModel->getMyClosedTickets($_SESSION['sAMAccountName']);
    //set page details
    $templateData->details = "The following tickets have had recent activity, please check an engineer has not requested a response or feedback left,";
    //check to see if user profile exists if it doesnt update details with message prompting to complete
    $profileDetails = $userProfileModel->getuserProfileBysAMAccountName($_SESSION['sAMAccountName']);
    isset($profileDetails) ? null : $templateData->details .= " you have yet to complete your profile, completing your profile will speed up adding tickets in future. <a href=\"/user/profile/\" class=\"hyperbutton\">Complete profile now</a>";
    $templateData->details .= " or you can <a href=\"/ticket/add/\" class=\"hyperbutton\">Create a new ticket</a>";

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('userView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
