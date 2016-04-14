<?php

class actionDigitalSignDefault {
  public function __construct()
  {
    $pagedata = new stdClass();
    $lockersModel = new lockersModel();

    //set report name
    $reportname = "Lockers";
    //set report title
    $pagedata->title = $reportname;
    $pagedata->details = "";
    $pagedata->reportResults = $lockersModel->getLockersByHelpdesk(1);
    //render template using $pagedata object
    require_once "views/digitalsignView.php";
  }
}
