<?php

class reportSettingsController {
  public function __construct()
  {
    //create new models for required data
    $helpdeskModel = new helpdeskModel();
    $ticketModel = new ticketModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Custom Settings";
    //set page details
    $templateData->details = "Setting a custom date and time range here will force reports to display this range, else they will display the previous month. Settings are stored for the session they are not persistant";
    //get list of helpdesks
    $templateData->helpdesks = $helpdeskModel->getListOfHelpdeskWithoutDeactivated();
    //Post Update Custom Settings
      if ($_POST) {
        foreach ($_POST["helpdesks"] as $value) {
          $helpdesks .= $value . ",";
        }
        $helpdesks = rtrim($helpdesks, ',');
        // check valid start date
        $_SESSION['customReportsRangeStart'] = checkdate( substr($_POST["date-range"] , 5, 2) , substr($_POST["date-range"] , 8, 2) , substr($_POST["date-range"] , 0, 4) ) ? substr($_POST["date-range"] , 0, 10) : null;
        $_SESSION['customReportsRangeEnd'] = checkdate( substr($_POST["date-range"] , 18, 2) , substr($_POST["date-range"] , 21, 2) , substr($_POST["date-range"] , 13, 4) ) ? substr($_POST["date-range"] , 13, 10) : null;
        $_SESSION['customReportsHelpdesks'] = htmlspecialchars($helpdesks);
        $templateData->success = "Settings updated, reports will now use your custom settings.";
      }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('reportSettings');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
