<?php

class userDefaultController {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $ticketModel = new ticketModel();
    $userProfileModel = new userProfileModel();
    $pagedata = new stdClass();
    //set report name
    $pagedata->title = "Recent Ticket Activity";
    $pagedata->reportResults = $ticketModel->getRecentActivityByOwner($_SESSION['sAMAccountName']);
    //set page details
    $pagedata->details = "The following tickets have had recent activity, please check an engineer has not requested a response or feedback left,";

    //check to see if user profile exists if it doesnt update details with message prompting to complete
    $profileDetails = $userProfileModel->getuserProfileBysAMAccountName($_SESSION['sAMAccountName']);
    isset($profileDetails) ? null : $pagedata->details .= " you have yet to complete your profile, completing your profile will speed up adding tickets in future. <a href=\"/user/profile/\" class=\"hyperbutton\">Complete profile now</a>";

    $pagedata->details .= " or you can <a href=\"/ticket/add/\" class=\"hyperbutton\">Create a new ticket</a>";
    // render page
    require_once "views/userView.php";
  }
}
