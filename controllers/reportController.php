<?php

class reportController {
  public function __construct()
  {
    // look for methods or render default routes
    // create methods object
    $methods = new Route();
    $methods->add('/', 'actionReportDefault');
    $methods->process(2);
  }

}
