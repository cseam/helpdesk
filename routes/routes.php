<?php
  // create routes object
  $route = new Route();
  // add top level routes & corisponding controllers
  // default routes
  $route->add('/', 'homeController');
  $route->add('/login', 'loginController');
  $route->add('/logout', 'logoutController');
  // top level landing pages routes
  $route->add('/user', 'userController');
  $route->add('/engineer', 'engineerController');
  $route->add('/manager', 'managerController');
  $route->add('/admin', 'adminController');
  // top level routes
  $route->add('/report', 'reportController');
  $route->add('/ticket', 'ticketController');
  $route->add('/changecontrol', 'changecontrolController');
  $route->add('/outofhours', 'outofhoursController');
  $route->add('/scheduledtask', 'scheduledtaskController');
