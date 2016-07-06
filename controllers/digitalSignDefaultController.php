<?php

class digitalSignDefaultController {
  public function __construct()
  {
    //create new models required
    $lockersModel = new lockersModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report title
    $templateData->title = "Lockers";
    $templateData->details = "";
    $templateData->reportResults = $lockersModel->getLockersByHelpdesk(1);

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('digitalsignView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
