<?php

class ticketController {
  public function __construct()
  {
    // look for methods or render default routes.
    // create methods object
    $methods = new Route();
    $methods->add('/', 'actionTicketDefault');
    $methods->add('/add', 'actionAddTicket');
    $methods->add('/update', 'actionUpdateTicket');
    $methods->add('/updated', 'actionUpdatedTicket');
    $methods->add('/view', 'actionViewTicket');
    $methods->add('/assign', 'actionAssignTicket');
    $methods->add('/forward', 'actionForwardTicket');
    $methods->add('/feedback', 'actionFeedbackTicket');
    $methods->add('/description', 'actionDescriptionTicket');
    $methods->add('/category', 'actionCategoryTicket');
    $methods->add('/additional', 'actionAdditionalTicket');
    $methods->process(2);
  }
}
