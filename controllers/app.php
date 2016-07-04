<?php

class app {
    public function __construct() {
      // load config & helper functions
      require_once "config/config.php";
      require_once "libraries/functions.php";
      // authentication check
      require_once "controllers/authenticationController.php";
      // add routes & process
      require_once "routes/routes.php";
      $route->process();
    }
}
