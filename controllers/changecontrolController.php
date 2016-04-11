<?php

class changecontrolController {
  public function __construct()
  {
    // look for methods or render default routes
    // create methods object
    $methods = new Route();
    $methods->add('/', 'actionAddChangeControl');
    $methods->add('/add', 'actionAddChangeControl');
    $methods->process(2);
  }
}
