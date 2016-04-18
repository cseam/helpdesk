<?php

class managerController {
  public function __construct()
  {
    //check engineer level before processing routes
    if ($_SESSION['engineerLevel'] != 2 && $_SESSION['superuser'] != 1) {
      $error = new stdClass();
      $error->title = "403 Forbidden";
      $error->message = "Opps! you dont have permission to view this page.";
      require_once "views/errorView.php";
      exit;
    }
    // look for methods or render default routes.
    // create methods object
    $methods = new Route();
    $methods->add('/', 'actionManagerDefault');
    $methods->add('/report', 'actionManagerReports');
    $methods->add('/objectives', 'actionViewObjectives');
    $methods->add('/addobjectives','actionAddObjectives');
    $methods->add('/modifyobjectives','actionModifyObjectives');
    $methods->process(2);
  }

}
