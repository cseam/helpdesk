<?php
// load config
require_once "config/config.php";

// authentication check
require_once "controllers/authentication.php";

// setup routing
require_once "routes/routingController.php";

// add routes
require_once "routes/routes.php";

// autoload controller classes
require_once "controllers/autoload.php";

// process routes
$route->process(1);
