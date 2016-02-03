<?php

class userController {
  public function __construct()
  {
    // look for methods or render default routes
    // create methods object
    $methods = new Route();
    $methods->add('/', 'userDefaultMethod');
    $methods->add('/add', 'addTicketMethod');
    $methods->process(2);

    // render page
    require_once "views/userView.php";
  }

}
