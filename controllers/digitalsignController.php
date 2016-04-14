<?php

class digitalsignController {
  public function __construct()
  {
    // look for methods or render default routes
    // create methods object.
    $methods = new Route();
    $methods->add('/', 'actionDigitalSignDefault');
    $methods->process(2);
  }

}
