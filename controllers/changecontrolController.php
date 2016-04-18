<?php

class changecontrolController {
  public function __construct()
  {
    //check engineer level before processing routes
    if ($_SESSION['engineerLevel'] < 1 && $_SESSION['superuser'] != 1) {
      $error = new stdClass();
      $error->title = "403 Forbidden";
      $error->message = "Opps! you dont have permission to view this page.";
      require_once "views/errorView.php";
      exit;
    }
    // look for methods or render default routes.
    // create methods object
    $methods = new Route();
    $methods->add('/', 'actionAddChangeControl');
    $methods->add('/add', 'actionAddChangeControl');
    $methods->process(2);
  }
}
