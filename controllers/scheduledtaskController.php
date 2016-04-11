<?php

class scheduledtaskController {
  public function __construct()
  {
    // look for methods or render default routes
    // create methods object
    $methods = new Route();
    $methods->add('/', 'actionAddScheduledtask');
    $methods->add('/add', 'actionAddScheduledtask');
    $methods->add('/modify', 'actionModifyScheduledtask');
    $methods->add('/delete', 'actionDeleteScheduledtask');
    $methods->process(2);
  }
}
