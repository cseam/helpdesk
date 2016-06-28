<?php

class authenticationController {
  function __construct()
  {
    // start sessions
    session_start();
    // check session contains authentication info
    if (empty($_SESSION['sAMAccountName'])) {
      // session looks empty route to login page if not already there
        $baseurl = explode('/',$_SERVER['REQUEST_URI']);
        if (!$_POST) {
          // needs some work to stop post to pages other than login working but in principal posts to login need to not reroute
          if (!preg_match("%login%", $baseurl[1])) {
            if (preg_match("%digitalsign%", $baseurl[1])) { } else {
              if (!preg_match("%logout%", $baseurl[1])) {
                  // if not on the logout page set the entry point
                    $favicons = array("/favicon.ico", "/apple-touch-icon.png", "/apple-touch-icon-precomposed.png");
                      if (in_array($_SERVER['REQUEST_URI'], $favicons)) {
                        $_SESSION['entrypoint'] = "/";
                      } else {
                        $_SESSION['entrypoint'] = $_SERVER['REQUEST_URI'];
                      }
              }
              // reroute
              header('Location: /login/');
              exit;
            }
          }
        }
    }
  }
}

new authenticationController();
// check users is authenticated else route to login.
