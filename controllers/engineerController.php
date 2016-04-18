<?php

class engineerController {
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
    $methods->add('/', 'actionEngineerDefault');
    $methods->add('/search', 'actionReportSearch');
    $methods->add('/lockers', 'actionReportLockers');
    $methods->add('/changecontrol', 'actionReportChangecontrol');
    $methods->add('/outofhours', 'actionReportOutofhours');
    $methods->add('/workrate', 'actionReportWorkrate');
    $methods->add('/objectives', 'actionViewObjectives');

    $methods->process(2);
  }

}
