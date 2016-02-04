<?php

class managerController {
  public function __construct()
  {
    // look for methods or render default routes
    // create methods object
    $methods = new Route();
    $methods->add('/', 'actionManagerDefault');
    $methods->process(2);
  }

}
