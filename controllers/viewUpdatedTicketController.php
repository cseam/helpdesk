<?php

class viewUpdatedTicketController {
  public function __construct()
  {
    //create empty object to store data for template
    $templateData = $_SESSION['pagedata'];
    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('updateTicketView');
    $view->setDataSrc($templateData);
    $view->render();
  }

}
