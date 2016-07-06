<?php

class ticketDefaultController {
  public function __construct()
  {
    //TODO no one should hit this atm
    //create new models required

    //create empty object to store data for template
    $templateData = new stdClass();

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('ticketView');
    $view->setDataSrc($templateData);
    $view->render();
  }

}
