<?php

class managerController {
  public function __construct()
  {
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
