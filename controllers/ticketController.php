<?php

class ticketController {
  public function __construct()
  {
    // look for methods or render default routes
    // create methods object
    $methods = new Route();
    $methods->add('/', 'actionTicketDefault');
    $methods->add('/add', 'actionAddTicket');
    $methods->add('/update', 'actionUpdateTicket');
    $methods->add('/view', 'actionViewTicket');
    //TODO Assign route
    //TODO Forward route
    //TODO feedback route
    $methods->process(2);
  }
}
