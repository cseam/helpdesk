<?php

class engineerController {
  public function __construct()
  {
    // look for methods or render default routes
    // create methods object
    $methods = new Route();
    $methods->add('/', 'actionEngineerDefault');
    $methods->process(2);
  }

}
