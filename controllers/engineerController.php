<?php

class engineerController {
  public function __construct()
  {
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
