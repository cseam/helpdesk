<?php

class userController {
  public function __construct()
  {
    // look for methods or render default routes.
    // create methods object
    $methods = new Route();
    $methods->add('/', 'actionUserDefault');
    $methods->add('/profile', 'actionUserProfile');
    $methods->add('/complete', 'actionComplete');
    $methods->process(2);
  }

}
