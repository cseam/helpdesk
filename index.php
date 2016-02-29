<?php
// load config
require_once "config/config.php";
// authentication check
require_once "controllers/authentication.php";
// setup routing
require_once "routes/routeClass.php";
// add routes
require_once "routes/routes.php";
// autoload controller classes, models & method classes.
require_once "controllers/autoload.php";
// load global functions
require_once "libraries/functions.php";
// process routes for top level(1)
$route->process(1);
