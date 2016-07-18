<?php

class actionCompleteController {
  public function __construct()
  {
    //create empty object to store data for template
    $templateData = new stdClass();
    $templateData->title = "Thankyou";
    $templateData->details = "Your change has been made to the database";

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('completeView');
    $view->setDataSrc($templateData);
    $view->render();
  }

}
