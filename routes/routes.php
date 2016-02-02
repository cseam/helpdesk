<?php
  // create routes object
  $route = new Route();
  // add top level routes & corisponding controllers
  $route->add('/', 'homeController');
  $route->add('/login', 'loginController');
  $route->add('/logout', 'logoutController');

  $route->add('/ticket', 'homeController');
  $route->add('/engineer', 'engineerController');
  $route->add('/manager', 'managerController');
  $route->add('/reports', 'reportsController');
  $route->add('/admin', 'adminController');
