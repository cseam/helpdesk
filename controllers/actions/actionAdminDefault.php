<?php

class actionAdminDefault {
  public function __construct()
  {
    $ticketModel = new ticketModel();
    //populate page content
    $pagedata = new stdClass();
    $pagedata->title = CODENAME . " Admin";
    $pagedata->details = "Superuser admin pages for ".CODENAME." to allow key stake holders the ability to manage helpdesk without requirment to change tables in the database.<br /><br />Changes to these pages effect all helpdesks, ensure you know what you are doing and snapshot the virtual machine before you begin.";
    // render page
    require_once "views/adminView.php";
  }
}
