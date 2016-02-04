<?php

class adminController {
  public function __construct()
  {
    // look for methods or render default routes
    // create methods object
    $methods = new Route();
    $methods->add('/', 'actionAdminDefault');
    $methods->process(2);
  }

}
