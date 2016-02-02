<?php
  // create routes object
  $route = new Route();
  // add top level routes & corisponding controllers
  $route->add('/', 'homeController');
  $route->add('/login', 'loginController');
  $route->add('/logout', 'logoutController');
