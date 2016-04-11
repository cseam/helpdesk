<?php

class outofhoursController {
  public function __construct()
  {
    // look for methods or render default routes
    // create methods object
    $methods = new Route();
    $methods->add('/', 'actionAddOutofhours');
    $methods->add('/add', 'actionAddOutofhours');
    $methods->process(2);
  }
}
