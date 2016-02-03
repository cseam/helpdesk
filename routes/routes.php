<?php
  // create routes object
  $route = new Route();
  // add top level routes & corisponding controllers
  //default routes
  $route->add('/', 'homeController');
  $route->add('/login', 'loginController');
  $route->add('/logout', 'logoutController');
  // top level routes
  $route->add('/user', 'userController');
  $route->add('/engineer', 'engineerController');
  $route->add('/manager', 'managerController');
  $route->add('/reports', 'reportsController');
  $route->add('/admin', 'adminController');
