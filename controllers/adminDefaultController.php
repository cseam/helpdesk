<?php

class adminDefaultController {
  public function __construct()
  {
    //create new models for required data
    $ticketModel = new ticketModel();
    //create empty object to store data for template
    $templateData = new stdClass();
    $templateData->title = CODENAME." Admin";
    $templateData->details = "Superuser admin pages for ".CODENAME." to allow key stake holders the ability to manage helpdesk without requirment to change tables in the database.<br /><br /><span class=\"reminder\">Changes to these pages effect all helpdesks, ensure you know what you are doing and snapshot the virtual machine before you begin.</span>";

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('adminView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
