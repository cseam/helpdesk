<?php

class authenticationController {
  function __construct()
  {
    // start sessions
    session_start();
    // check session populated if empty should forward to login in most cases
    if (empty($_SESSION['sAMAccountName'])) {
        $baseurl = explode('/', $_SERVER['REQUEST_URI']);
        $reroute = 1; // set reroute to be default behaviour
        // dont reroute login pages as your already there and we dont want an endless loop
        if (preg_match("%login%", $baseurl[1])) {
          $reroute = 0;
        }
        // dont reroute digitalsign as they open to public
        if (preg_match("%digitalsign%", $baseurl[1])) {
          $reroute = 0;
        }
        // reroute assuming a match hasnt been found
        if ($reroute == 1) {
          header('Location: /login/');
          exit;
        }
        // if not on the logout page set the entry point
        if (!preg_match("%logout%", $baseurl[1])) {
          $noentrypoint = array("/favicon.ico", "/apple-touch-icon.png", "/apple-touch-icon-precomposed.png", "/login");
          $_SESSION['entrypoint'] = $_SERVER['REQUEST_URI'];
          if (in_array($_SERVER['REQUEST_URI'], $noentrypoint)) {
            $_SESSION['entrypoint'] = "/";
          }
        }
    }
  }
}
// check users session is populated else reroute to login.
new authenticationController();
